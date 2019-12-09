pimcore.registerNS("pimcore.plugin.DivanteGoogleTranslationBundle");

pimcore.plugin.DivanteGoogleTranslationBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.DivanteGoogleTranslationBundle";
    },

    initialize: function () {
        pimcore.plugin.broker.registerPlugin(this);
    },
});

var DivanteGoogleTranslationBundlePlugin = new pimcore.plugin.DivanteGoogleTranslationBundle();
