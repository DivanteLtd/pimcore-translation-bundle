pimcore.registerNS("pimcore.plugin.GoogleTranslateBundle");

pimcore.plugin.GoogleTranslateBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.GoogleTranslateBundle";
    },

    initialize: function () {
        pimcore.plugin.broker.registerPlugin(this);
    },
});

var GoogleTranslateBundlePlugin = new pimcore.plugin.GoogleTranslateBundle();
