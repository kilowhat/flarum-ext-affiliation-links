import app from 'flarum/app';
import icon from 'flarum/helpers/icon';
import Component from 'flarum/Component';
import Button from 'flarum/components/Button';
import Select from 'flarum/components/Select';

export default class RuleEdit extends Component {
    init() {
        this.rule = this.props.rule;
        this.dirty = false;
        this.processing = false;
        this.toggleFields = false;

        if (this.rule === null) {
            this.initNewField();
        }
    }

    initNewField() {
        this.rule = app.store.createRecord('flagrow-affiliation-links-rules', {
            attributes: {
                match_component: 'host',
                match_type: 'exact',
                match_pattern: '',
                replacement: '',
                comment: '',
            },
        });
    }

    boxTitle() {
        if (this.rule.exists) {
            return [
                this.rule.match_pattern(),
                ' ',
                this.rule.comment() ? m('em', '(' + this.rule.comment().split('\n')[0] + ')') : null,
            ];
        }

        return app.translator.trans('flagrow-affiliation-links.admin.buttons.new-rule');
    }

    view() {
        return m('.Flagrow-AffiliationLinks-Rule-Box', [
            (this.rule.exists ? m('span.fa.fa-arrows.Flagrow-AffiliationLinks-Rule-Box--handle.js-rule-handle') : null),
            m('.Button.Button--block.Flagrow-AffiliationLinks-Rule-Header', {
                onclick: () => {
                    this.toggleFields = !this.toggleFields;
                },
            }, [
                m('.Flagrow-AffiliationLinks-Rule-Header-Title', this.boxTitle()),
                m('div', [
                    (this.rule.exists ? [
                        app.translator.trans('flagrow-affiliation-links.admin.buttons.edit-rule'),
                        ' ',
                    ] : null),
                    icon(this.toggleFields ? 'chevron-up' : 'chevron-down'),
                ]),
            ]),
            (this.toggleFields ? this.viewFields() : null),
        ]);
    }

    viewFields() {
        return m('form.Flagrow-AffiliationLinks-Rule-Body', [
            m('.Form-group', [
                m('label', app.translator.trans('flagrow-affiliation-links.admin.rules.match-component')),
                Select.component({
                    value: this.rule.match_component(),
                    onchange: this.updateAttribute.bind(this, 'match_component'),
                    options: {
                        uri: app.translator.trans('flagrow-affiliation-links.admin.component-options.uri'),
                        host: app.translator.trans('flagrow-affiliation-links.admin.component-options.host'),
                        path: app.translator.trans('flagrow-affiliation-links.admin.component-options.path'),
                    },
                }),
                m('.helpText', app.translator.trans('flagrow-affiliation-links.admin.rules.match-component-help')),
            ]),
            m('.Form-group', [
                m('label', app.translator.trans('flagrow-affiliation-links.admin.rules.match-type')),
                Select.component({
                    value: this.rule.match_type(),
                    onchange: this.updateAttribute.bind(this, 'match_type'),
                    options: {
                        exact: app.translator.trans('flagrow-affiliation-links.admin.type-options.exact'),
                        simple: app.translator.trans('flagrow-affiliation-links.admin.type-options.simple'),
                        regex: app.translator.trans('flagrow-affiliation-links.admin.type-options.regex'),
                    },
                }),
                m('.helpText', app.translator.trans('flagrow-affiliation-links.admin.rules.match-type-help')),
            ]),
            m('.Form-group', [
                m('label', app.translator.trans('flagrow-affiliation-links.admin.rules.match-pattern')),
                m('input.FormControl', {
                    type: 'text',
                    value: this.rule.match_pattern(),
                    oninput: m.withAttr('value', this.updateAttribute.bind(this, 'match_pattern')),
                }),
                m('.helpText', app.translator.trans('flagrow-affiliation-links.admin.rules.match-pattern-help')),
            ]),
            m('.Form-group', [
                m('label', app.translator.trans('flagrow-affiliation-links.admin.rules.replacement')),
                m('input.FormControl', {
                    type: 'text',
                    value: this.rule.replacement(),
                    oninput: m.withAttr('value', this.updateAttribute.bind(this, 'replacement')),
                }),
                m('.helpText', app.translator.trans('flagrow-affiliation-links.admin.rules.replacement-help')),
            ]),
            m('.Form-group', [
                m('label', app.translator.trans('flagrow-affiliation-links.admin.rules.comment')),
                m('textarea.FormControl', {
                    value: this.rule.comment(),
                    oninput: m.withAttr('value', this.updateAttribute.bind(this, 'comment')),
                }),
            ]),
            m('.ButtonGroup', [
                Button.component({
                    type: 'submit',
                    className: 'Button Button--primary',
                    children: app.translator.trans('flagrow-affiliation-links.admin.buttons.' + (this.rule.exists ? 'save' : 'add') + '-rule'),
                    loading: this.processing,
                    disabled: !this.readyToSave(),
                    onclick: this.savePolicy.bind(this),
                }),
                (this.rule.exists ? Button.component({
                    type: 'submit',
                    className: 'Button Button--danger',
                    children: app.translator.trans('flagrow-affiliation-links.admin.buttons.delete-rule'),
                    loading: this.processing,
                    onclick: this.deletePolicy.bind(this),
                }) : ''),
            ]),
        ]);
    }

    updateAttribute(attribute, value) {
        this.rule.pushAttributes({
            [attribute]: value,
        });

        this.dirty = true;
    }

    readyToSave() {
        return this.dirty;
    }

    savePolicy() {
        this.processing = true;

        const createNewRecord = !this.rule.exists;

        this.rule.save(this.rule.data.attributes).then(() => {
            if (createNewRecord) {
                this.initNewField();
                this.toggleFields = false;
            }

            this.processing = false;
            this.dirty = false;

            m.redraw();
        }).catch(err => {
            this.processing = false;

            throw err;
        });
    }

    deletePolicy() {
        if (!confirm(app.translator.trans('flagrow-affiliation-links.admin.messages.delete-rule-confirmation', {
                match_pattern: this.rule.match_pattern(),
            }).join(''))) {
            return;
        }

        this.processing = true;

        this.rule.delete().then(() => {
            this.processing = false;

            m.redraw();
        }).catch(err => {
            this.processing = false;

            throw err;
        });
    }
}
