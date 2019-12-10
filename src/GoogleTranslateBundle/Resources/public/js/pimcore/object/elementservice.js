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

pimcore.object.elementservice.addCopyButton = function (id, fieldName, component, type, lang) {
    return new Ext.Button({
        iconCls: "pimcore_icon_copy",
        cls: 'pimcore_button_transparent',
        tooltip: t("copy_from_source_lang"),
        handler: function () {
            Ext.Ajax.request({
                url: "/admin/object/get-field-data",
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
                        if (type == 'wysiwyg') {
                            CKEDITOR.instances[component.editableDivId].setData(res.data);
                        }  else {
                            component.setRawValue(res.data);
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
                        if (type == 'wysiwyg') {
                            CKEDITOR.instances[component.editableDivId].setData(res.data);
                        } else {
                            component.setRawValue(res.data);
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