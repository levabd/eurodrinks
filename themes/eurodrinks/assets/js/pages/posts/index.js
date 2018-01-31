var $postList = $('.row.article.post-list');
var loaderTemplate =
  '<div id="loader-block" class="col d-flex justify-content-around">' +
  '<div class="loader"></div>' +
  '</div>'
;

$('.news-see-all').click(function (e) {
  e.preventDefault();
  loadNextArticles();
});

function loadNextArticles() {

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

      var postAlreadyOnPage = false;
      var postId = false;

      data.responseJSON.posts.data.forEach(function (post) {
        if (newsPostIds.indexOf(post.id) != -1) {
          postAlreadyOnPage = true;
          postId = post.id;
        }
      });

      if (postAlreadyOnPage) {
        console.log('Post with id ' + postId + 'already on page');
        $postList.append('<div class="col-12 mt-2 pt-2"><p class="text-center">Больше нет новостей для отображения</p></div> ');
        return
      }
      if (data.responseJSON.content && data.responseJSON.content !== "") {
        $postList.append(data.responseJSON.content);
        newsPagePaginationData.current_page = next_page;
        setNewsLinkListeners();
        [].forEach.call($postList[0].querySelectorAll('img'), function (img) {
          if (img.getAttribute('data-src')===null){
            return
          }
          img.setAttribute('src', img.getAttribute('data-src'))
          img.onload = function () {
            img.removeAttribute('data-src')
          }
        })
      }
    }
  })
} //end of getPosts function

$(document).on('ajaxPromise', function () {
  if (document.getElementById('loader-block')) {
    return;
  }
  $postList.append(loaderTemplate);
});
$(document).on('ajaxFail', function (event, context, error) {
  $postList.find('#loader-block').remove();
  console.log('Error getting news', error);
  newsPagePaginationData.current_page = parseInt(newsPagePaginationData.current_pag) - 1;
});

$(document).on('ajaxDone', function () {
  $postList.find('#loader-block').remove();
});


// OPEN article
function setNewsLinkListeners() {
  $('.article a').click(function (e) {
    e.preventDefault();
    $.request('onLoadArticleData', {
      data: {post_id: $(this).data('postId')},
      complete: function (data) {
        if (data.responseJSON.result && data.responseJSON.result !== "") {
          var $modal = $('#modal-news-article-content');
          $modal.children().remove();
          $modal.append(data.responseJSON.result);
          $('#modal-news-article').modal('show');
        }
      }
    })
  });
}

setNewsLinkListeners()
