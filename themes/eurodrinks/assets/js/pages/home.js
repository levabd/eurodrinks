var BrandHandler = function BrandHandler(brands){

  brands.forEach(function (_brand, index) {
    var newChunkByFour = [];
    _brand.product_chunk_by_four.forEach(function (chunk) {

      if (!Array.isArray(chunk)) {

        var _newChunk = [];
        Object.keys(chunk).forEach(function (t, number) {
          _newChunk.push(chunk[t])
        });
        newChunkByFour.push(_newChunk)

      } else {
        newChunkByFour.push(chunk)
      }
    });

    brands[index].product_chunk_by_four= newChunkByFour;
    var newChunkByFTwo = [];

    _brand.product_chunk_by_two.forEach(function (chunk) {
      if (!Array.isArray(chunk)) {
        var _newChunk = [];
        Object.keys(chunk).forEach(function (t, number) {
          _newChunk.push(chunk[t])
        });
        newChunkByFTwo.push(_newChunk)
      } else {
        newChunkByFTwo.push(chunk)
      }
    });
    brands[index].product_chunk_by_two= newChunkByFTwo;

  });
  this.brands = brands;

  var findBrand = function findBrand(brandId) {
    if (!brandId){
      console.warn('CarouselRenderer::findBrand - No brand id provided');
      return
    }
    var brandFound = null;
    self.brands.forEach(function (brand) {
      if (brand.id === brandId) {
        brandFound = brand
      }
    });
    self.brandId = brandId;
    return brandFound;
  }

  var hasProducts = function hasProducts(brandId){
    if (!brandId){
      console.warn('CarouselRenderer::findBrand - No brand id provided');
      return
    }

    return this.findBrand(brandId).products.length;
  }
  var self =this;
  return {
    findBrand: findBrand,
    hasProducts:hasProducts
  }
};

var CarouselRenderer = function CarouselRenderer(defaultImage){
  this.defaultImage= defaultImage;
  var self = this;
  return {
    renderBy: function renderBy(brand, id, array_to_handle) {

      var classes='';
      if (id==='by-two-carousel-'){
        classes= 'd-block d-md-none d-lg-none d-lx-none';
      }else{
        classes='d-none d-sm-none d-md-block d-lg-block d-lx-block';
      }

      var template = '<div id="' + id+ brand.id+ '" class="carousel slide '+classes+'" \
      data-ride="carousel" data-interval="false" style="height: 100%;">\
      <div class="carousel-inner" role="listbox" style="height: 100%;">';

      array_to_handle.forEach(function (product_items, index) {
        var is_active = index === 0 ? 'active' : '';
        template += '<div class="carousel-item ' + is_active + '">\
              <div class="carousel-caption d-flex flex-column" style="height: 100%;">\
              <div class="brand-image-wrapper">\
                   <img class="brand-logo" src="' + brand.image.path + '" alt="' + brand.import_name + '">\
              </div>\
              <div class="items d-flex justify-content-around ">';


        product_items.forEach(function (product) {
          template += '<div class="product-item assess" id="product-item-' + product.id + '">';
          if (product.image) {
            template += '<img data-src="' + product.image.path + '" class="product-item-image" alt="' + product.display_name + '" data-product-id="' + product.id + '">';
          } else {
            template += '<img data-src="'+self.defaultImage+'" alt="{{ product_item.name_uk }}">';
          }

          template += '<div class="name text-center">' + product.display_name + '</div>\
      <div class="percentage">\
        ' + product.capacity + '/' + product.degree + 'deg;\
      </div>';
          template += '</div>';
        });
        template += '</div>';
        template += '</div>';
        template += '</div>';
      });
      template += '</div>';
      template += '<a class="carousel-control-prev" href="#' +id+ brand.id+ '-active" role="button"  data-slide="prev">\
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>\
    <span class="sr-only">Previous</span>\
    </a>\
    <a class="carousel-control-next" href="#' + id+ brand.id + '-active" role="button"  data-slide="next">\
    <span class="carousel-control-next-icon" aria-hidden="true"></span>\
    <span class="sr-only">Next</span>\
    </a>';
      template += '</div>';

      return template;
    },
    renderBrand: function renderBrand(brand) {

      var template = '<div class="row preview-products-row" style="display:none;height: 0px;" id="preview-products-row-' + brand.id + '">\
    <div class="col-12">\
    <div class="preview-products">'
      template += this.renderBy(brand, 'by-two-carousel-', brand.product_chunk_by_two);
      template += this.renderBy(brand, 'by-four-carousel-', brand.product_chunk_by_four);
      template += '</div>';
      template += '</div>';
      template += '</div>';
      return template;
    }
  }
};
