pimcore.registerNS("pimcore.plugin.TranslateBundle");

pimcore.plugin.TranslateBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.TranslateBundle";
    },

    initialize: function () {
        pimcore.plugin.broker.registerPlugin(this);
    },
});

var TranslateBundlePlugin = new pimcore.plugin.TranslateBundle();
