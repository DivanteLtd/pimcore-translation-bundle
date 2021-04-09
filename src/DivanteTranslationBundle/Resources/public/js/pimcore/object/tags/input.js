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

pimcore.registerNS("pimcore.object.tags.input");
pimcore.object.tags.input = Class.create(pimcore.object.tags.input, {

    getLayoutEdit: function () {
        var input = {
            fieldLabel: this.fieldConfig.title,
            name: this.fieldConfig.name,
            componentCls: "object_field",
            labelWidth: 100
        };

        if (this.data) {
            input.value = this.data;
        }

        if (this.fieldConfig.width) {
            input.width = this.fieldConfig.width;
        } else {
            input.width = 250;
        }

        if (this.fieldConfig.labelWidth) {
            input.labelWidth = this.fieldConfig.labelWidth;
        }
        input.width += input.labelWidth;

        if (this.fieldConfig.columnLength) {
            input.maxLength = this.fieldConfig.columnLength;
            input.enforceMaxLength = true;
        }

        if (this.fieldConfig["regex"]) {
            input.regex = new RegExp(this.fieldConfig.regex);
        }

        this.component = new Ext.form.TextField(input);

        if (this.context.language) {
            this.translateButton = new pimcore.object.elementservice.translateButton(
                this.object.data.general.o_id,
                this.fieldConfig.name,
                this.component,
                'input',
                this.context.language
            );
        } else {
            this.translateButton = {};
        }

        if (this.fieldConfig.showCharCount) {
            var charCount = Ext.create("Ext.Panel", {
                bodyStyle: '',
                margin: '0 0 0 0',
                bodyCls: 'char_count',
                width: input.width,
                height: 17
            });

            this.component.setStyle("margin-bottom", "0");
            this.component.addListener("change", function (charCount) {
                this.updateCharCount(this.component, charCount);
            }.bind(this, charCount));

            this.updateCharCount(this.component, charCount);

            return Ext.create("Ext.Panel", {
                cls: "object_field",
                style: "margin-bottom: 10px",
                layout: {
                    type: 'vbox',
                    align: 'left'
                },
                items: [
                    this.component,
                    charCount,
                    this.translateButton,
                ]
            });

        } else {
            return Ext.create('Ext.form.FieldContainer', {
                labelWidth: input.width,
                layout: 'hbox',
                items: [
                    this.component,
                    this.translateButton,
                ],
                componentCls: "object_field",
                border: false,
                style: {
                    padding: 0
                },
            });
        }
    },
});
