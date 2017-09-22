(function (global, factory) {
    if (typeof define === 'function' && define.amd) {
        define(factory);
    } else if (typeof module === 'object' && module.exports) {
        module.exports = factory();
    } else {
        global.completeGenerate = factory();
    }
}(this, function () {

    var completeGenerate,


        completeGenerate = function (data) {
            return new AutoComplete(data);
        };

    completeGenerate.fn = AutoComplete.prototype = {

        clone: function () {
            return this;
        },
    }

    function AutoComplete(options) {

        var defaults = {
            selector: '#completeGenerate',
            elements: '#elements',
            selectorId: '#completeGenerateId',
            inputsValue: [],
            onSelect: null,
            onHtml: null,
        };
        this.opts = extend({}, defaults, options);

        this.init();
    }

    AutoComplete.prototype.init = function () {
        this.autocomplete();
        _bindEvents.call(this);
    };


    AutoComplete.prototype.elements = function () {
        const elements = document.querySelector(this.opts.elements).options;
        var elementsArray = [];

        const inputsValue = this.opts.inputsValue;
        [].forEach.call(elements, function (div) {
            var itemArray = [];
            for (var j = 0; j < inputsValue.length; j++) {
                itemArray.push(div.getAttribute(inputsValue[j]));
            }
            elementsArray.push(itemArray)
        });
        return elementsArray;
    }

    AutoComplete.prototype.renderItem = function(item, search) {

        search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&amp;');
        var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");

        document.querySelector(this.opts.selectorId).value = ''
        return this.opts.onHtml(item, re);
    }

     AutoComplete.prototype.onSelect = function(e, term, item) {
         return this.opts.onSelect(e, term, item);
     }

    AutoComplete.prototype.autocomplete = function (a) {
        var elements = this.elements();
        const onSelect = this.onSelect.bind(this)
        const renderItem = this.renderItem.bind(this)
        new autoComplete({
            selector: this.opts.selector,
            minChars: 1,
            source: function (term, suggest) {

                term = term.toLowerCase();
                var choices = elements;
                var suggestions = [];
                for (var i = 0; i < choices.length; i++)
                    if (~(choices[i][0] + ' ' + choices[i][1]).toLowerCase().indexOf(term))
                        suggestions.push(choices[i]);
                suggest(suggestions);

            },
            renderItem: renderItem,
            onSelect: onSelect

        });
    }

    function _bindEvents() {

        if (typeof this.opts.onOpen === 'function') {
            this.opts.onOpen.call(this);
        }
    }


    function extend() {
        for (var i = 1; i < arguments.length; i++) {
            for (var key in arguments[i]) {
                if (arguments[i].hasOwnProperty(key)) {
                    arguments[0][key] = arguments[i][key];
                }
            }

        }
        return arguments[0];
    }

    return completeGenerate;
}));