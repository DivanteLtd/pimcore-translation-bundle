pimcore.registerNS("pimcore.object.elementservice.x");

pimcore.object.elementservice.translateButton = function (id, fieldName, component, type, lang) {
    var provider = pimcore.globalmanager.get('translationBundle_provider');

    return new Ext.Button({
        iconCls: "pimcore_icon_translations",
        cls: 'pimcore_button_transparent',
        tooltip: t("translate_field"),
        handler: function () {
            handleTranslationRequest(id, fieldName, component, type, lang)
        }.bind(this),
        style: "margin-left: 10px; filter:grayscale(100%);",
    });

};

function handleTranslationRequest(id, fieldName, component, type, lang, formality) {
    Ext.Ajax.request({
        url: "/admin/object/translate-field",
        method: "GET",
        params: {
            sourceId: id,
            fieldName: fieldName,
            lang: lang,
            type: type,
            formality: formality
        },
        success: function (response) {
            var res = Ext.decode(response.responseText);

            if (res.success) {
                switch (type) {
                    case 'wysiwyg':
                        CKEDITOR.instances[component.editableDivId].setData(res.data);
                        break;
                    case 'input':
                        component.setRawValue(res.data);
                        break;
                    case 'textarea':
                        component.component.setValue(res.data);
                        break;
                }
            } else {
                pimcore.helpers.showPrettyError('object', t("error"), t("saving_failed"), res.message);
            }
        }
    });
}