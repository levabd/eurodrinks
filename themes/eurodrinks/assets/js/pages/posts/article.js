var didScroll = false;
var allArtilesLoaded = false;
var $articleList = $('.container.article-detail');
var buttonUpId ="#up-button";
var upButton =   ' <div class="icon-up"  id="up-button"></div>';

function initUpButton(){
  $(upButton ).insertBefore( $( $(".container.article-detail> .row:nth-child(2) > .col > h1")) );
  // set to top content
  $('.icon-up').hover(function(){
    $(this).attr('data-content', trans('to_top'));
  }).on('click', function(e){
    $('html, body').animate({scrollTop: 0},2000);
  });
}

$(window).scroll(function () { //watches scroll of the window
  didScroll = true;
});

//Sets an interval so your window.scroll event doesn't fire constantly. This waits for the user to stop scrolling for not even a second and then fires the loadNextArticles function (and then the getPost function)
setInterval(function () {
  if (didScroll) {
    didScroll = false;
    if (($(document).height() - $(window).height()) - $(window).scrollTop() < 10) {
      // alert(3454);
      (!allArtilesLoaded) && getNextArticle();
    } else if ($(window).scrollTop() ===0  ){

      if ($(buttonUpId).length){
        $(buttonUpId).remove();
      }
      return
    }

    if (!$(buttonUpId).length){
      initUpButton()
    }
  }
}, 250);


//This function runs when user scrolls. It will call the new posts if the max_page isn't met and will fade in/fade out the end of page message
function getNextArticle() {

  $.request('onLoadArticleData', {
    data: {
      article_ids: loadedPostIds
    },
    complete: function (data) {
      if (data.responseJSON.result == 'no_articles') {
        console.log('No more records to load');

        if (!$('#no-data-row').length) {
          $articleList.append('<div class="row" id="no-data-row"><div class="col text-center"><h1>' + trans('no_article_data') + '</h1></div></div>');
        }
        allArtilesLoaded = true;
        return;
      }
      var response = data.responseJSON;
      if (response && response !== "" && response.article_rendered !== "" && response.article_id !== "") {
        $articleList.append(response.article_rendered);
        loadedPostIds.push(response.article_id);
        initImages(response.article_id);
      }
    }
  })
}

function initImages(articleId) {

  var id = articleId || null;

  if (id === null) {
    console.log('articleId was not provided');
    return
  }

  var $article = $('#article-' + id);
  if (!$article) {
    console.log('Article with id: article-' + id + ' not found!');
    return;
  }

  var articleImages = $article.find('img');
  if (!articleImages.length) {
    console.log('No images in article with id: article-' + id);
    return;
  }

  var initImages = articleImages;
  articleImages.each(function (index, image) {
    image.remove();
  });

  var imagesBlockId = '#images-block-' + id;
  var $sliderInitBlock = $(imagesBlockId);
  if (!$sliderInitBlock.length) {
    console.log('No block images-block-' + id + '. Cant insert images.');
    return;
  }
  var rect = $article.get(0).getBoundingClientRect();

  $sliderInitBlock.css('margin-left', '-' + rect.left + 'px');
  $sliderInitBlock.children().each(function (index, el, array) {
    el.remove();
  });

  initImages.each(function (index, image) {
    image.style.height = '257px';
    image.style.width = 'auto';
    $sliderInitBlock.get(0).appendChild(image);
  });

  var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);

  $(imagesBlockId).css('width', w);

  $(imagesBlockId).slick({
    dots: false,
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    centerMode: true,
    variableWidth: true
  });


  /// insert article
  var smartInformer = SliderExporter('images-block-', id, 20, 90);

  smartInformer.setArticle($article.get(0));
  smartInformer.calculateArticleHeight();
  smartInformer.initiateCreating();
}

var loaderTemplate = '<div class="row" id="loader-block"><div class="col text-center"><div class="loader"></div> </div></div>';

$(document).on('ajaxPromise', function () {

  if (document.getElementById('loader-block')) {
    return;
  }
  $articleList.append(loaderTemplate);
});
$(document).on('ajaxFail', function (event, context, error) {
  $articleList.find('#loader-block').remove();
  console.log('Error getting news', error);
});
$(document).on('ajaxDone', function () {
  $articleList.find('#loader-block').remove();
});

initImages(loadedPostIds[0]);
