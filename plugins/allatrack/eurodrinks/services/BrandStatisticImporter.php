<?php namespace Allatrack\Eurodrinks\Services;

use Allatrack\Eurodrinks\Models\Brand;
use Doctrine\DBAL\Driver\PDOException;
use \PHPExcelReader\SpreadsheetReader as Reader;
use Illuminate\Support\Facades\Log;

class BrandStatisticImporter {

    private $errors = [];

    public $storePath;

    public $brandsTable = [];

    public $statisticTable = [];

    private $nomenclaturePath;

    private $imported;

    private $config = [];

    public function __construct()
    {
        $this->config = config("allatrack.eurodrinks::stat_importer");
        $this->storePath = storage_path($this->config['stat_file_path']);
        $this->nomenclaturePath = storage_path($this->config['nomenclature_path']);
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param $file
     *
     * @return bool
     */
    public function putNomenclature($file)
    {
        try
        {

            if (file_put_contents($this->nomenclaturePath, $file) === false)
            {
                $this->writeError("Put nomenclature error while saving file");

                return false;
            }

        } catch (\Exception $e)
        {
            $this->writeError(sprintf("Put nomenclature error while saving file: %s", $e->getMessage()));

            return false;
        }

        $this->imported = true;

        return true;
    }

    public function import()
    {
        if ( ! $this->imported)
        {
            $this->writeError("Please save nomenclature using putNomenclature method before parsing it");

            return false;
        }

        if ($this->storePath === "" || $this->nomenclaturePath == "")
        {
            $this->writeError("Paths were not set");

            return false;
        }

        try
        {
            $spreadsheetReader = new Reader($this->nomenclaturePath);
        } catch (\Exception $e)
        {
            $this->writeError(sprintf("Error while opening xls file: %s", $e->getMessage()));

            return false;
        }

        $rowcount = $spreadsheetReader->rowcount($sheet_index = 0);

        if ($rowcount == 0)
        {
            $this->writeError("Imported file has no rows");

            return false;
        }
        $prevIndex = 0;
        $prevBrand = 0;

        if ($this->parseExcelSuccessfully($rowcount, $spreadsheetReader, $prevIndex, $prevBrand) === false)
        {
            return false;
        }

        if ($this->prepareStatTableSuccessfully($spreadsheetReader) === false)
        {
            return false;
        }


        if ($this->preparetotalRowSuccessfully() === false)
        {
            return false;
        }

        try
        {
            file_put_contents($this->storePath, json_encode($this->statisticTable));
        } catch (\Exception $e)
        {
            $this->writeError(sprintf("Can store file in path: %s. Occurred error: %s.", $this->storePath,
                $e->getMessage()
            ));

            return false;
        }

        return true;
    }

    /**
     * @param                                   $rowcount
     * @param \PHPExcelReader\SpreadsheetReader $spreadsheetReader
     * @param                                   $prevIndex
     * @param                                   $prevBrand
     *
     * @return boolean
     */
    private function parseExcelSuccessfully($rowcount, $spreadsheetReader, $prevIndex, $prevBrand)
    {
        try
        {
            for ($i = $this->config ['row_to_start_from']; $i < $rowcount; $i ++)
            {
                $brandName = str_replace("\"", "", trim($spreadsheetReader->val($i, 1)));

                if ($brandName != '')
                {

                    if (is_string($brandName))
                    {
                        $brandFromDb = Brand::where("slug", $brandName)
                            ->orWhere("name_ru", $brandName)
                            ->orWhere("name_uk", $brandName)
                            ->orWhere("name_en", $brandName)
                            ->orWhere("import_name", $brandName)
                            ->first();
                    } else
                    {
                        throw new \Exception("brand_name_not_string");
                    }


                    if (is_null($brandFromDb))
                    {
                        $this->errors[] = sprintf("Can not find brand in database with name: %s. Row index: %d.", $brandName, $i);
                        Log::warning(sprintf("Can not find brand in database with name: %s. Row index: %d.", $brandName, $i));
                    } else
                    {
                        Log::info(sprintf("%s found and will be used for stat import", $brandFromDb->slug));
                    }

                    $brandId = $brandFromDb->id;

                    $this->brandsTable[$brandId] = [];
                    $this->brandsTable[$brandId]["row_start"] = $i;

                    // first row
                    if ($prevIndex != 0)
                    {
                        // other rows
                        $this->brandsTable[$prevBrand]["row_end"] = $prevIndex;
                    }

                    $prevIndex = $i;
                    $prevBrand = $brandId;

                    if ( ! isset($this->brandsTable[$brandId]["products"]))
                    {
                        $this->brandsTable[$brandId]["products"] = [];
                    }

                } else
                {
                    $this->brandsTable[$prevBrand]["products"][] = trim($spreadsheetReader->val($i, 2));
                    $prevIndex = $i;
                }

                if ($i + 1 == $rowcount)
                {
                    $this->brandsTable[$prevBrand]["row_end"] = $this->brandsTable[$prevBrand]["row_start"] + count($this->brandsTable[$prevBrand]["products"]);
                }
            }

        } catch (PDOException $e)
        {
            $this->writeError(sprintf("No DB connection. Please check if it is correctly set up"));

            return false;
        } catch (\Exception $e)
        {
            $this->writeError(sprintf("Error while parsing imported file: %s.", $e->getMessage()));

            return false;
        }

        return true;
    }

    /**
     * @param \PHPExcelReader\SpreadsheetReader $spreadsheetReader
     *
     * @return bool
     */
    private function prepareStatTableSuccessfully($spreadsheetReader)
    {
        try
        {
            $previousYear = intval(trim($spreadsheetReader->raw($this->config['years']['current_year_indexes']['row'], $this->config['years']['current_year_indexes']['col'])));
            $currentYear = intval(trim($spreadsheetReader->raw($this->config['years']['previous_year_indexes']['row'], $this->config['years']['previous_year_indexes']['col'])));
            $percentageColumn = intval(trim($spreadsheetReader->raw($this->config['years']['percentage_indexes']['row'], $this->config['years']['percentage_indexes']['col'])));

            foreach ($this->brandsTable as $brand => $content)
            {
                $this->statisticTable[$brand] = [];
                foreach ([$previousYear, $currentYear, $percentageColumn] as $columnIndex => $column)
                {
                    $this->statisticTable[$brand][$column] = [];
                    $rowStart = $content["row_start"];

                    foreach ($content["products"] as $productItem)
                    {
                        $totalPerProduct = 0;

                        $this->statisticTable[$brand][$column][$productItem]['months'] = [];
                        foreach ($this->config['months_indexes'] as $key => $monthIndex)
                        {
                            $rawValue = floatval(str_replace(" ", "", $spreadsheetReader->raw($rowStart + 1, $monthIndex + $columnIndex)));
                            $this->statisticTable[$brand][$column][$productItem]["months"][] = $rawValue;
                            $totalPerProduct += $rawValue;
                        }

                        if ($columnIndex == 2)
                        {
                            try
                            {
                                $result = $this->statisticTable[$brand][$currentYear][$productItem]["total"] / $this->statisticTable[$brand][$previousYear][$productItem]["total"] * 100 - 100;
                            } catch (\Exception $e)
                            {
                                $result = 0;
                            }

                            $this->statisticTable[$brand][$column][$productItem]["total"] = $result;
                            $this->statisticTable[$brand][$column][$productItem]["total_g_l"] = $result / 10;
                        } else
                        {
                            $this->statisticTable[$brand][$column][$productItem]["total"] = $totalPerProduct;
                            $this->statisticTable[$brand][$column][$productItem]["total_g_l"] = $totalPerProduct / 10;
                        }

                        $rowStart ++;
                    }
                }
            }
        } catch (\Exception $e)
        {
            $this->writeError(sprintf("Error while preparing stat data: %s.", $e->getMessage()));

            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    private function prepareTotalRowSuccessfully()
    {

        try
        {
            foreach ($this->statisticTable as $brandKey => $brands)
            {
                foreach ($brands as $yearKey => $years)
                {
                    $totalInYear = [];
                    $totalInYear["total"] = [];
                    $totalInYear["total"]["months"] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

                    foreach ($years as $product)
                    {
                        $totalPerYear = 0;

                        foreach ($product["months"] as $index => $month)
                        {
                            if (isset($totalInYear["total"]["months"][$index]))
                            {
                                $totalInYear["total"]["months"][$index] += $month;
                            } else
                            {
                                $totalInYear["total"]["months"][$index] = $month;
                            }
                            $totalPerYear += $totalInYear["total"]["months"][$index];
                        }
                    }

                    $totalInYear["total"]["total"] = $totalPerYear;
                    $totalInYear["total"]["total_g_l"] = $totalPerYear / 10;
                    $this->statisticTable[$brandKey][$yearKey]["total"] = $totalInYear["total"];
                }
            }
        } catch (\Exception $e)
        {
            $this->writeError(sprintf("Error while preparing stat total row: %s.", $e->getMessage()));

            return false;
        }

        return true;
    }

    /**
     * @param string $errMessage
     */
    private function writeError($errMessage)
    {
        Log::error($errMessage);
        $this->errors[] = $errMessage;
    }
}