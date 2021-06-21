pimcore.registerNS("pimcore.plugin.TranslationBundle");

pimcore.plugin.TranslationBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.TranslationBundle";
    },

    initialize: function () {
        Ext.Ajax.request({
            url: "/admin/translate-provider",
            method: "GET",
            success: function (response) {
                var res = Ext.decode(response.responseText);
                pimcore.globalmanager.add('translationBundle_provider', res.provider);
            }
        });

        pimcore.plugin.broker.registerPlugin(this);
    },
});

var TranslationBundlePlugin = new pimcore.plugin.TranslationBundle();
