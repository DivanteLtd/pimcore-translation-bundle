/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Enterprise License (PEL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PEL
 */

pimcore.registerNS("pimcore.object.elementservice.x");

pimcore.object.elementservice.translateButton = function (id, fieldName, component, type, lang) {
    return new Ext.Button({
        iconCls: "pimcore_icon_translations",
        cls: 'pimcore_button_transparent',
        tooltip: t("translate_field"),
        handler: function () {
            Ext.Ajax.request({
                url: "/admin/object/translate-field",
                method: "GET",
                params: {
                    sourceId: id,
                    fieldName: fieldName,
                    lang: lang,
                    type: type
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
        }.bind(this),
        style: "margin-left: 10px; filter:grayscale(100%);",
    });
};
