pimcore.registerNS("pimcore.plugin.TranslationBundle");

pimcore.plugin.TranslationBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.TranslationBundle";
    },

    initialize: function () {
        pimcore.plugin.broker.registerPlugin(this);
    },
});

var TranslationBundlePlugin = new pimcore.plugin.TranslationBundle();
