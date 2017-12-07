'use strict';

/**
 * Create DIV element and paste element with given ID
 *
 * @param {string) smartInformerName - element id prefix
 * @param {number} id - element id number
 * @param {number} _percentageFrom - paste block from
 * @param {number} _percentageTo - paste block to
 * @returns {{setArticle: _setArticle, calculateArticleHeight: _calculateArticleHeight, initiateCreating: _initiateCreating}}
 * @constructor
 */
function SliderExporter(smartInformerName, id, _percentageFrom, _percentageTo) {

  function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
  }

  if (!isNumeric(_percentageFrom) || !isNumeric(_percentageTo)) {
    console.error('SliderExporter.constructor: Provided percentages must be numeric only.' + ' _percentageFrom: ' + _percentageFrom + ' _percentageTo: ' + _percentageTo + ' given');
  }

  if (!smartInformerName) {
    console.error('SliderExporter.constructor: smartInformerName must be specified');
  }

  if (typeof id == 'undefined' || id == '') {
    console.error('SliderExporter.constructor: Root Id was excepted but ' + id + ' given');
  }

  if (!_percentageFrom) {
    console.warn('SliderExporter.constructor: Percentage from was excepted but it was not given. Default value (30% will be used)');
  }

  if (!_percentageTo) {
    console.warn('SliderExporter.constructor: Percentage to was excepted but it was not given. Default value (60% will be used)');
  }

  if (_percentageFrom < 0 || _percentageFrom > 100) {
    console.error('SliderExporter.constructor: _percentageFrom param must be between 0-100 and lower than _percentageTo. ' + _percentageFrom + ' given');
  }

  if (_percentageTo < 0 || _percentageTo > 100) {
    console.error('SliderExporter.constructor: _percentageFrom param must be between 0-100 and lower than _percentageTo. ' + _percentageFrom + ' given');
  }

  if (_percentageFrom > _percentageTo) {
    console.error('SliderExporter.constructor: _percentageFrom > _percentageTo. This must be _percentageFrom < _percentageTo');
  }

  var rootId = id;
  var marketGidCompositeId = smartInformerName + id;
  var smartInformer = document.getElementById(marketGidCompositeId);
  console.log(marketGidCompositeId);
  smartInformer.parentNode.removeChild(smartInformer);

  var percentageFrom = _percentageFrom === null || _percentageFrom === undefined ? 30 : _percentageFrom;
  var percentageTo = _percentageTo === null || _percentageTo === undefined ? 60 : _percentageTo;
  var articleHeight = 0;
  var article;
  var informerRootDiv;
  var offsetHeightFrom;
  var offsetHeightTo;

function _setArticle(_article){
  article = _article
}

  function _initMarketGidCompositeRootDiv() {

    informerRootDiv = document.createElement('div');
    informerRootDiv.id = smartInformerName + 'Root' + rootId;
    informerRootDiv.classList.add('yui3-cssreset');

    // reset all the styles of the informerRootDiv
    var initialStyles = {
      'animation': "none",
      'animation-delay': "0",
      'animation-direction': "normal",
      'animation-duration': "0",
      'animation-fill-mode': "none",
      'animation-iteration-count': "1",
      'animation-name': "none",
      'animation-play-state': "running",
      'animation-timing-function': "ease",
      'backface-visibility': "visible",
      'background': "0",
      'background-attachment': "scroll",
      'background-clip': "borderBox",
      'background-color': "transparent",
      'background-image': "none",
      'background-origin': "paddingBox",
      'background-position': "0 0",
      'background-position-x': "0",
      'background-position-y': "0",
      'background-repeat': "repeat",
      'background-size': "auto auto",
      'border': "0",
      'border-style': "none",
      'border-width': "medium",
      'border-color': "inherit",
      'border-bottom': "0",
      'border-bottom-color': "inherit",
      'border-bottom-left-radius': "0",
      'border-bottom-right-radius': "0",
      'border-bottom-style': "none",
      'border-bottom-width': "medium",
      'border-collapse': "separate",
      'border-image': "none",
      'border-left': "0",
      'border-left-color': "inherit",
      'border-left-style': "none",
      'border-left-width': "medium",
      'border-radius': "0",
      'border-right': "0",
      'border-right-color': "inherit",
      'border-right-style': "none",
      'border-right-width': "medium",
      'border-spacing': "0",
      'border-top': "0",
      'border-top-color': "inherit",
      'border-top-left-radius': "0",
      'border-top-right-radius': "0",
      'border-top-style': "none",
      'border-top-width': "medium",
      'bottom': "auto",
      'box-shadow': "none",
      'box-sizing': "contentBox",
      'caption-side': "top",
      'clear': "none",
      'clip': "auto",
      'color': "inherit",
      'columns': "auto",
      'column-count': "auto",
      'column-fill': "balance",
      'column-gap': "normal",
      'column-rule': "medium none currentColor",
      'column-rule-color': "currentColor",
      'column-rule-style': "none",
      'column-rule-width': "none",
      'column-span': "1",
      'column-width': "auto",
      'content': "normal",
      'counter-increment': "none",
      'counter-reset': "none",
      'cursor': "auto",
      'direction': "ltr",
      'display': "inline",
      'empty-cells': "show",
      'float': "left",
      'font': "normal",
      'font-family': "inherit",
      'font-size': "medium",
      'font-style': "normal",
      'font-variant': "normal",
      'font-weight': "normal",
      'height': "auto",
      'hyphens': "none",
      'left': "auto",
      'letter-spacing': "normal",
      'line-height': "normal",
      'list-style': "none",
      'list-style-image': "none",
      'list-style-position': "outside",
      'list-style-type': "disc",
      'margin': "0",
      'margin-bottom': "25px",
      'margin-left': "0",
      'margin-right': "0",
      'margin-top': "0",
      'max-height': "none",
      'max-width': "none",
      'min-height': "0",
      'min-width': "0",
      'opacity': "1",
      'orphans': "0",
      'outline': "0",
      'outline-color': "invert",
      'outline-style': "none",
      'outline-width': "medium",
      'overflow': "visible",
      'overflow-x': "visible",
      'overflow-y': "visible",
      'padding': "0",
      'padding-bottom': "0",
      'padding-left': "0",
      'padding-right': "0",
      'padding-top': "0",
      'page-break-after': "auto",
      'page-break-before': "auto",
      'page-break-inside': "auto",
      'perspective': "none",
      'perspective-origin': "50% 50%",
      'position': "static",

      'right': "auto",
      'tabSize': "8",
      'table-layout': "auto",
      'text-align': "inherit",
      'text-alignLast': "auto",
      'text-decoration': "none",
      'text-decoration-color': "inherit",
      'text-decoration-line': "none",
      'text-decoration-style': "solid",
      'text-indent': "0",
      'text-shadow': "none",
      'text-transform': "none",
      'top': "auto",
      'transform': "none",
      'transform-style': "flat",
      'transition': "none",
      'transition-delay': "0s",
      'transition-duration': "0s",
      'transition-property': "none",
      'transition-timing-fFunction': "ease",
      'unicode-bidi': "normal",
      'vertical-align': "baseline",
      'visibility': "visible",
      'white-space': "normal",
      'widows': "0",
      'width': "100%",
      'word-spacing': "normal",
      'z-index': "auto"
    };

    Object.keys(initialStyles).forEach(function (key) {
      informerRootDiv.style.setProperty(key, initialStyles[key], "important");
    });
  }

  /**
   * Insert informer to DOM
   *
   * @param {Element} element - web Element
   * @param {boolean} _before - need to insert before
   * @private
   */
  function _insert(element, _before) {

    /**
     * Important: Part of business logic
     * ----
     * You cant render informer block if article height less then block height -245px
     */
    if (articleHeight <= 300) {

      console.warn('SliderExporter._insert: Article is too small to render informer block');
      // so clean DOM
      inserted = true;
      return;
    }

    var before = _before || false;
    var nextNodeIndex = Array.prototype.indexOf.call(element.parentNode.children, element);
    var nextNode = element.parentNode.children[nextNodeIndex + 1];

    if (_hasChildTags(element, ['FIGURE', 'IMG', 'TABLE', 'IFRAME', 'TIME', 'CODE'])) {

      // todo: Provide for going down to paste in
      element.parentNode.insertBefore(informerRootDiv, element.nextSibling);

      informerRootDiv = document.getElementById(informerRootDiv.id);
      informerRootDiv.appendChild(smartInformer);
      inserted = true;
      return;
    }

    if (['H1', 'H2', 'H3', 'H4', 'H5', 'H6'].indexOf(element.tagName) != -1 || _hasSpecialNextElement(nextNode, ['UL', 'OL'])) {

      if (typeof nextNode.nextSibling != 'undefined') {
        element.parentNode.insertBefore(informerRootDiv, nextNode.nextSibling);
      } else {
        console.error('SliderExporter._insert: Cant insert informer block after image - it does not exist');
      }
    } else if (_hasSpecialNextElement(nextNode, ['FIGURE', 'IMG', 'TABLE', 'IFRAME', 'TIME', 'CODE'])) {

      if (typeof nextNode.nextSibling != 'undefined') {
        element.parentNode.insertBefore(informerRootDiv, nextNode.nextSibling);
      } else {
        console.error('SliderExporter._insert: Cant insert informer block after image - it does not exist');
      }
    } else {
      element.parentNode.insertBefore(informerRootDiv, before ? element : element.nextSibling);
    }

    informerRootDiv = document.getElementById(informerRootDiv.id);
    informerRootDiv.appendChild(smartInformer);
    inserted = true;
  }

  /**
   * You MUST insert informer block after image
   */
  function _hasSpecialNextElement(nextNode, specialTags) {

    return typeof nextNode != 'undefined' && specialTags.indexOf(nextNode.tagName) != -1 || _hasChildTags(nextNode, specialTags);
  }

  function _hasChildTags(node, tags) {

    if (!tags || !tags.length) {
      console.warn('SliderExporter._hasChildTags: tags MUST NOT be empty array');
      return false;
    }

    if (typeof node == 'undefined') {
      return false;
    }

    if (!node.children || node.children.length === 0) {
      return false;
    }

    var result = false;

    [].forEach.call(node.children, function (_node) {

      if (_node.children && _node.children.length > 0) {
        [].forEach.call(_node.children, function (_node2) {
          if (!result) {
            result = _hasChildTags(_node2, tags);
          }
        });
      }

      if (!result) {
        tags.indexOf(_node.tagName) != -1 && (result = true);
      }
    });

    return result;
  }

  function _getFirstChildByTag(node, tags) {
    if (!tags) {
      console.warn('SliderExporter._getFirstChildByTag: - tag MUST NOT be empty array');
      return false;
    }

    if (typeof node == 'undefined') {
      console.warn('SliderExporter._getFirstChildByTag: - Node MUST NOT be empty ');
      return false;
    }

    if (!node.children || node.children.length === 0) {
      return false;
    }

    var result = null;

    [].forEach.call(node.children, function (_node) {

      if (_node.children && _node.children.length > 0) {
        [].forEach.call(_node.children, function (_node2) {
          if (!result) {
            result = _getFirstChildByTag(_node2, tags);
          }
        });
      }

      if (!result) {
        tags.indexOf(_node.tagName) != -1 && (result = _node);
      }
    });

    return result;
  }

  var cumulativeGlobal = 0;
  var inserted = false;
  var cursor = {};

  Object.defineProperties(cursor, {
    beforeGoal: { get: function get() {
      return cumulativeGlobal === 0 || cumulativeGlobal <= offsetHeightFrom;
    } },
    neededGoal: { get: function get() {
      return cumulativeGlobal >= offsetHeightFrom && cumulativeGlobal <= offsetHeightTo;
    } },
    afterGoal: { get: function get() {
      return cumulativeGlobal >= offsetHeightTo || cumulativeGlobal <= articleHeight;
    } }
  });

  function _getRealHeight(_element) {

    var _elementClientHeight = _element.clientHeight;

    //console.log(temp.replace("<br>", "\n"););
    if (_elementClientHeight) {
      return _elementClientHeight;
    }

    if (_element.children && _element.children.length === 0 && _elementClientHeight === 0) {
      return _elementClientHeight;
    }

    [].forEach.call(_element.children, function (node) {
      _elementClientHeight = node.children ? _getRealHeight(node) : node.clientHeight + _getMargin(node, 'bottom') + _getMargin(node, 'top');
    });

    return _elementClientHeight;
  }

  function _createIntoParentSibling(_el) {
    if (_el.parentNode.children.length > 1) {
      _create(_el.nextSibling);
    } else {
      _createIntoParentSibling(_el.parentNode.nextSibling);
    }
  }

  function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }

  function _getMargin(_element, direction) {
    var style = _element.currentStyle || window.getComputedStyle(_element);
    var margin = style['margin' + capitalizeFirstLetter(direction.toLowerCase())].replace('px', '');
    return isNumeric(margin) ? parseInt(margin) : 0;
  }

  function _create(_element) {

    if (inserted) {
      return;
    }

    if (_element.clientHeight === undefined) {
      return;
    }

    var nodeClientRealHeight = _element.clientHeight == 0 ? _getRealHeight(_element) : _element.clientHeight + _getMargin(_element, 'bottom') + _getMargin(_element, 'top');

    if (nodeClientRealHeight === 0) {
      return;
    }

    cumulativeGlobal += nodeClientRealHeight;
    // console.log(_element, cumulativeGlobal, nodeClientRealHeight);

    if (cursor.beforeGoal) {
      return;
    }

    if (cursor.neededGoal) {

      if (_hasChildTags(_element, ['P', 'BLOCKQUOTE', 'PRE'])) {
        cumulativeGlobal -= nodeClientRealHeight;

        [].forEach.call(_element.children, function (_e) {
          _create(_e);
        });
        return;
      }

      if (['TR', 'TD', 'THEAD', 'TBODY', 'TFOOTER', 'TABLE'].indexOf(_element.tagName) != -1) {
        var _getTableNode = function _getTableNode(_element) {
          if (_element.tagName === 'TABLE') {
            return _element;
          }

          return _element.parentNode && _element.parentNode.tagName !== 'TABLE' ? _getTableNode(_element.parentNode) : _element.parentNode;
        };

        _insert(_getTableNode(_element));
        return;
      }

      if (_element.tagName === 'LI') {
        _insert(_element.parentNode);
        return;
      }

      _insert(_element);
      return;
    }

    if (cursor.afterGoal) {
      cumulativeGlobal -= nodeClientRealHeight;

      if (nodeClientRealHeight < articleHeight && ['IFRAME', 'IMG', 'FIGURE', 'TIME', 'CODE'].indexOf(_element.tagName) != -1) {

        _insert(_element);
        return;
      }

      /**
       * Part of business logic
       * ----
       * If there is large paragraph, which does not
       * suit our range - insert informer before it.
       */
      if (['P', 'BLOCKQUOTE', 'PRE', 'SPAN'].indexOf(_element.tagName) != -1) {

        if (['BLOCKQUOTE', 'PRE'].indexOf(_element.tagName) != -1) {

          if (!_element.children) {
            _insert(_element);
            return;
          }

          [].forEach.call(_element.children, function (_e) {
            _create(_e);
          });

          return;
        }

        if (_hasChildTags(_element, ['IMG', 'FIGURE', 'IFRAME'])) {
          _insert(_getFirstChildByTag(_element, ['IMG', 'FIGURE', 'IFRAME']));
          return;
        }

        _insert(_element, true);
        return;
      }

      if (_element.children && _element.children.length) {

        [].forEach.call(_element.children, function (_e) {
          _create(_e);
        });
      } else {
        _createIntoParentSibling(_element);
      }
    }
  }

  function _initiateCreating() {

    if (!article.children && !article.length) {
      console.error('SliderExporter._initiateCreating: Article cant be without any children');
    }

    articleHeight === 0 && _calculateArticleHeight();

    if (article.length) {
      [].forEach.call(article, function (article) {
        [].forEach.call(article.children, function (_e) {
          _create(_e);
        });
      });
    } else {
      [].forEach.call(article.children, function (_e) {
        _create(_e);
      });
    }
  }

  function _calculateArticleHeight() {

    articleHeight = _getRealHeight(article);
    offsetHeightFrom = articleHeight * percentageFrom / 100;
    offsetHeightTo = articleHeight * percentageTo / 100;
  }

  _initMarketGidCompositeRootDiv();

  // give public API method
  return {
    setArticle: _setArticle,
    calculateArticleHeight: _calculateArticleHeight,
    initiateCreating: _initiateCreating
  };
}