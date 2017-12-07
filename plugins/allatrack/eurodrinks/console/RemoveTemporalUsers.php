<?php namespace Allatrack\Eurodrinks\Console;

use Backend\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RemoveTemporalUsers extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'eurodrinks:remove-temporal-users';

    /**
     * @var string The console command description.
     */
    protected $description = 'There is a temporal users in the system. See docs.';

    /**
     * Execute the console command.
     * @return void
     */
    public function fire()
    {
        try{
            $temporal_users = User::where('available_until', '>=', Carbon::now());

            $count = $temporal_users->count();

            $temporal_users->delete();
        }catch (\Exception $e){
            $this->output->writeln('Error while removing users!');
        }

        $this->output->writeln($count  .' Users were removed!');
    }
}
