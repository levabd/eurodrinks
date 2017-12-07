var blockToRender = '<div class="bottles"></div> ';

var Component = Vue.component('brand-products', {
  template: '<div>\
                   <img :id="\'product-image-\'+product.id" \
                    :src="product.image.path"\
                    :alt="product.name" \
                    v-for="product in products" :key="product.id"\
                    @click="selectItem(product.id, $event)">\
                </div>',
  props: {
    products: {
      type: Array,
      default: [],
      required: true,
    }
  },
  methods: {
    selectItem: function (productId, event) {
      // $('.brand-product-box img.selected').each(function (index, element) {
      //   element.classList.remove('selected');
      // });
      // event.target.classList.add('selected');
    }
  }
});

var app = new Vue({
  el: '#vue-app',
  data: function () {
    return {
      brands: window.brands,
      currentWaitingBrandId: null,
      currentWaitingProductRowIndex: null,
      selectedBrand: this.initSelectedProducts(),
      currentProductRowIndex: null,
      previousSelectedBrandId: null
    }
  },
  components: {
    // <my-component> будет доступен только в шаблоне родителя
    'brand-products': Component
  },
  computed: {

    activeBrand: function () {
      var vm = this;
      var selected = null;
      Object.keys(vm.selectedBrand).forEach(function (kei) {
        if (vm.selectedBrand[kei]) {
          selected = kei;
        }
      });
      return selected
    }
  },
  methods: {
    brandChunk:function(){
      var i, j, temparray, chunk = 4;
      var brandChunk = [];
      for (i = 0, j = window.brands.length; i < j; i += chunk) {
        temparray = window.brands.slice(i, i + chunk);
        brandChunk.push(temparray);
      }
    return brandChunk
    },

    initSelectedProducts: function () {
      var selectedBrand = {};

      this.brandChunk().forEach(function (brands) {
        brands.forEach(function (brand) {
          selectedBrand[brand.id] = false;
        })
      });

      return selectedBrand;
    },
    unSelectSelectedItems: function () {
      var vm = this;
      $('.col-lg-3.col-md-6.text-center.brand-box').each(function (index, element) {
        element.classList.remove('selected');
        vm.currentProductRowIndex = null;
      });

      $('.brand-product-box').children().each(function (index, element) {
        element.classList.remove('selected');
        vm.currentProductRowIndex = null;
      });
    },
    setActiveBrand: function (brandId, currentWaitingProductRowIndex) {
      this.selectedBrand[brandId] = true;
      this.currentProductRowIndex = currentWaitingProductRowIndex;
    },
    getBrandById: function (brandId) {
      var brand = null;
      this.brands.forEach(function (_brand) {
        if (_brand.id === parseInt(brandId)) {
          brand = _brand
        }
      });
      if (brand === null) {
        console.log("Brand with id " + brandId + "not found");
      }
      return brand
    },
    showBrandProducts: function (brandId, currentProductRowIndex, event) {

      var brandProductNumber = this.getBrandById(brandId).products.length;


      console.log(brandProductNumber);
      if (brandProductNumber>10)

      $('#product-row-' + currentProductRowIndex)
        .show(8, 'ease-out')
        .animate({
            height: '150px',
          }
        )
      var vm = this;

      if (parseInt(vm.activeBrand) === brandId) {
        vm.currentProductRowIndex = null;
        vm.previousSelectedBrandId = vm.activeBrand;
        vm.selectedBrand[vm.activeBrand] = false;
        return
      }

      // console.log(vm.currentProductRowIndex, currentProductRowIndex);
      if (vm.activeBrand !== null) {
        vm.previousSelectedBrandId = vm.activeBrand;
        var element = document.getElementById('brand-box-' + brandId).parentNode;
        element.classList.remove('unselected');
        element.classList.add('selected');


        // vm.currentWaitingBrandId = brandId;
        // vm.currentWaitingProductRowIndex = currentProductRowIndex;

        // Object.keys(vm.selectedBrand).forEach(function (brandBoxKey) {
        //     vm.selectedBrand[brandBoxKey] = false;
        // });
        //
        //
        // vm.currentWaitingBrandId = brandId;
        // vm.currentWaitingProductRowIndex = currentProductRowIndex;
        //
        // vm.currentProductRowIndex = null;

      } else {
        vm.currentProductRowIndex = currentProductRowIndex;
        vm.selectedBrand[brandId] = true;
      }
    },
    getBrandProductId: function (id) {
      return 'brand-' + id + '-products-box';
    },
    showBrandProductsOnMup: function (id) {
      return 'brand-' + id + '-products-box';
    },
    afterLeave: function () {

      if (this.currentWaitingBrandId !== null && this.currentWaitingProductRowIndex !== null) {
        this.setActiveBrand(this.currentWaitingBrandId, this.currentWaitingProductRowIndex);
        this.currentWaitingBrandId = null;
        this.currentWaitingProductRowIndex = null;
      }
    },
    beforeEnterProductRow: function () {
      $('html, body').animate({
        scrollTop: $('#brand-box-' + this.activeBrand).offset().top - 10
      }, 800);
    }
  }
});