webpackJsonp([2],{

/***/ "./node_modules/_babel-loader@7.1.5@babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/_vue-loader@13.7.3@vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/member/group/Last.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    name: "Last",
    props: ['game', 'group'],
    data: function data() {
        return {
            last: {}
        };
    },

    created: function created() {
        console.log(this.game.id);
    },
    watch: {
        game: function game() {
            console.log('changed');
            //this.loadLast();
        }
    },
    methods: {
        loadLast: function loadLast() {
            var vm = this;
            axios.get('/last', {
                params: {
                    game: vm.game.id
                }
            }).then(function (response) {
                var json = response.data;
                vm.last = json.data;
            }).catch(function (error) {
                console.log(error);
            });
        }
    }
});

/***/ }),

/***/ "./node_modules/_css-loader@0.28.11@css-loader/index.js!./node_modules/_vue-loader@13.7.3@vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-beb36cce\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/_vue-loader@13.7.3@vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/member/group/Last.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/_css-loader@0.28.11@css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.dayProfit[data-v-beb36cce]{\n    color:red;font-weight: bold;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/_vue-loader@13.7.3@vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-beb36cce\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/_vue-loader@13.7.3@vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/member/group/Last.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "table",
    {
      staticClass: "th",
      attrs: { border: "0", cellpadding: "0", cellspacing: "0" }
    },
    [
      _c("tbody", [
        _c(
          "tr",
          [
            _c("td", { staticClass: "bolds", attrs: { height: "28px" } }, [
              _vm._v(_vm._s(_vm.game.title) + " -- "),
              _c("span", { staticClass: "gameGroup" }, [
                _vm._v(_vm._s(_vm.group.title))
              ])
            ]),
            _vm._v(" "),
            _vm._m(0),
            _vm._v(" "),
            _c("td", { staticClass: "bolds" }, [
              _c("span", { attrs: { id: "number" } }, [
                _vm._v(_vm._s(_vm.last.issue))
              ]),
              _vm._v("期賽果\n        ")
            ]),
            _vm._v(" "),
            _vm._l(_vm.last.numbers, function(noValue) {
              return _c("td", {
                class: _vm.game.no_style + noValue,
                attrs: { width: "24" }
              })
            })
          ],
          2
        )
      ])
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("td", { staticClass: "dayProfit" }, [
      _vm._v("今天輸贏："),
      _c("span", { staticClass: "shuyingjieguo2", attrs: { id: "sy" } }, [
        _vm._v("0.0")
      ])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-loader/node_modules/vue-hot-reload-api")      .rerender("data-v-beb36cce", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/_vue-style-loader@3.1.2@vue-style-loader/index.js!./node_modules/_css-loader@0.28.11@css-loader/index.js!./node_modules/_vue-loader@13.7.3@vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-beb36cce\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/_vue-loader@13.7.3@vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/member/group/Last.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/_css-loader@0.28.11@css-loader/index.js!./node_modules/_vue-loader@13.7.3@vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-beb36cce\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/_vue-loader@13.7.3@vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/member/group/Last.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/_vue-style-loader@3.1.2@vue-style-loader/lib/addStylesClient.js")("d3b1a52a", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/_css-loader@0.28.11@css-loader/index.js!../../../../../node_modules/_vue-loader@13.7.3@vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-beb36cce\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../node_modules/_vue-loader@13.7.3@vue-loader/lib/selector.js?type=styles&index=0!./Last.vue", function() {
     var newContent = require("!!../../../../../node_modules/_css-loader@0.28.11@css-loader/index.js!../../../../../node_modules/_vue-loader@13.7.3@vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-beb36cce\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../node_modules/_vue-loader@13.7.3@vue-loader/lib/selector.js?type=styles&index=0!./Last.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ "./resources/assets/js/member/group/Last.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/_vue-style-loader@3.1.2@vue-style-loader/index.js!./node_modules/_css-loader@0.28.11@css-loader/index.js!./node_modules/_vue-loader@13.7.3@vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-beb36cce\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/_vue-loader@13.7.3@vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/member/group/Last.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/_vue-loader@13.7.3@vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/_babel-loader@7.1.5@babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/_vue-loader@13.7.3@vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/member/group/Last.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/_vue-loader@13.7.3@vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-beb36cce\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/_vue-loader@13.7.3@vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/member/group/Last.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-beb36cce"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/member/group/Last.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-loader/node_modules/vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-beb36cce", Component.options)
  } else {
    hotAPI.reload("data-v-beb36cce", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});