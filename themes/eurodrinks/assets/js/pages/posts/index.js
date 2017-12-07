var didScroll = false;
var $postList = $('.container.news');
var loaderTemplate = '<div class="row" id="loader-block">' +
                    '<div class="col text-center">' +
                    '<div class="loader"></div>' +
                    '</div>' +
                    '</div>';
var upButton =   ' <div class="icon-up"  id="up-button"></div>';

function initUpButton(){
  $(upButton ).insertBefore( $( $(".container.news>h1.text-left:first-child")) );
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
      loadNextArticles();

    } else if ($(window).scrollTop() ===0  ){

      if ($("#up-button").length){
        $("#up-button").remove();
      }
      return
    }

    if (!$("#up-button").length){
      initUpButton()
    }
  }
}, 250);


//This function runs when user scrolls. It will call the new posts if the max_page isn't met and will fade in/fade out the end of page message
function loadNextArticles() {

  // noinspection JSUnresolvedVariable  see themes/eurodrinks/pages/news.htm:67
  var current_page = parseInt(newsPagePaginationData.current_page);
  var last_page = parseInt(newsPagePaginationData.last_page);

  if (current_page < last_page) {
    getPosts(current_page + 1);
    $('#end_of_page').hide();
  } else {
    $('#end_of_page').fadeIn();
  }
}

//Ajax call to get your new posts
function getPosts(next_page) {
  $.request('onLoadPaginationData', {
    data: {
      next_page: next_page,
      per_page: newsPagePaginationData.per_page
    },
    complete: function (data) {
      if (data.responseJSON.result && data.responseJSON.result!=="") {
        $postList.append(data.responseJSON.result);
        newsPagePaginationData.current_page = next_page;

      }
    }
  })
} //end of getPosts function



$(document).on('ajaxPromise', function() {

  if (document.getElementById('loader-block')){
    return;
  }
  $postList.append(loaderTemplate);
});
$(document).on('ajaxFail', function(event, context, error) {
  $postList.find('#loader-block').remove();
  console.log('Error getting news', error);
  newsPagePaginationData.current_page = parseInt( newsPagePaginationData.current_pag)-1;
});

$(document).on('ajaxDone', function() {
  $postList.find('#loader-block').remove();
});

