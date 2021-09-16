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

pimcore.registerNS("pimcore.object.tags.wysiwyg");
pimcore.object.tags.wysiwyg = Class.create(pimcore.object.tags.wysiwyg, {

    getLayoutEdit: function () {
        var width = '600';

        this.getLayout();
        this.component.on("afterlayout", this.initCkEditor.bind(this));
        this.component.on("beforedestroy", function () {
            if (this.ckeditor) {
                this.ckeditor.destroy();
                this.ckeditor = null;
            }
        }.bind(this));
        if (this.fieldConfig.width) {
            width = this.fieldConfig.width;
        }

        if (this.context.language) {
            this.translateButton = new pimcore.object.elementservice.translateButton(
                this.object.data.general.o_id,
                this.fieldConfig.name,
                this,
                'wysiwyg',
                this.context.language,
                this.context
            );
        } else {
            this.translateButton = {};
        }

        this.component.width = 550;

        return Ext.create('Ext.form.FieldContainer', {
            labelWidth: this.fieldConfig.width,
            layout: 'hbox',
            items: [
                this.component,
                this.translateButton,
            ],
            componentCls: "object_field custom_wysiwyg",
            border: false,
            width: width,
            style: {
                padding: 0,
            },
        });
    },
});
