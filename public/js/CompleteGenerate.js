(function (global, factory) {
    if (typeof define === 'function' && define.amd) {
        define(factory);
    } else if (typeof module === 'object' && module.exports) {
        module.exports = factory();
    } else {
        global.CompleteGenerate = factory();
    }
}(this, function () {

    var CompleteGenerate ,
        data = {
        'selector': '#completeGenerate',
        'elements': '#elements',
        'selectorId': '#completeGenerateId',
        'inputsValue': [],
        onSelect,
        html,

    }

    function init(e) {
        data = e
        autocomplete()
        clear()
        return data
    }

    function elements() {
        const customers = document.querySelector(data.elements).options;
        var customerArray = [];
        console.log(document.querySelector(data.elements));
        [].forEach.call(customers, function (div) {
            var itemArray = [];
            for (var j = 0; j < data.inputsValue.length; j++) {
                itemArray.push(div.getAttribute(data.inputsValue[j]));
            }
            customerArray.push(itemArray)
        });
        return customerArray;
    }

    function onSelect(e, term, item) {
    }

    function html(item) {
    }

    function renderItem(item, search) {
        search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&amp;');
        var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
        document.querySelector(data.selectorId).value = ''
        return data.html(item, re);
    }

    function clear() {

        const selector = document.querySelector(data.selector),
            selectorId = document.querySelector(data.selectorId);
        selector.addEventListener('blur', function () {
            if (!selectorId.value) {
                selector.value = "";
                selectorId.value = '';
            }

        });
        return;
    }


    function autocomplete() {

        new autoComplete({
            selector: data.selector,
            minChars: 1,
            source: function (term, suggest) {
                term = term.toLowerCase();
                var choices = elements();
                var suggestions = [];
                for (var i = 0; i < choices.length; i++)
                    if (~(choices[i][0] + ' ' + choices[i][1]).toLowerCase().indexOf(term))
                        suggestions.push(choices[i]);
                suggest(suggestions);

            },
            renderItem: renderItem,
            onSelect: data.onSelect,
        });
    }


    // Métodos y atributos públicos del módulo
    return {
        init,

    }
}));




