'use strict';

System.register('flagrow/affiliation-links/components/AffiliationSettingsModal', ['flarum/app', 'flarum/components/SettingsModal', 'flagrow/affiliation-links/components/RuleList'], function (_export, _context) {
    "use strict";

    var app, SettingsModal, RuleList, AffiliationSettingsModal;
    return {
        setters: [function (_flarumApp) {
            app = _flarumApp.default;
        }, function (_flarumComponentsSettingsModal) {
            SettingsModal = _flarumComponentsSettingsModal.default;
        }, function (_flagrowAffiliationLinksComponentsRuleList) {
            RuleList = _flagrowAffiliationLinksComponentsRuleList.default;
        }],
        execute: function () {
            AffiliationSettingsModal = function (_SettingsModal) {
                babelHelpers.inherits(AffiliationSettingsModal, _SettingsModal);

                function AffiliationSettingsModal() {
                    babelHelpers.classCallCheck(this, AffiliationSettingsModal);
                    return babelHelpers.possibleConstructorReturn(this, (AffiliationSettingsModal.__proto__ || Object.getPrototypeOf(AffiliationSettingsModal)).apply(this, arguments));
                }

                babelHelpers.createClass(AffiliationSettingsModal, [{
                    key: 'title',
                    value: function title() {
                        return app.translator.trans('flagrow-affiliation-links.admin.settings.title');
                    }
                }, {
                    key: 'form',
                    value: function form() {
                        return [RuleList.component()];
                    }
                }]);
                return AffiliationSettingsModal;
            }(SettingsModal);

            _export('default', AffiliationSettingsModal);
        }
    };
});;
'use strict';

System.register('flagrow/affiliation-links/components/RuleEdit', ['flarum/app', 'flarum/helpers/icon', 'flarum/Component', 'flarum/components/Button', 'flarum/components/Select'], function (_export, _context) {
    "use strict";

    var app, icon, Component, Button, Select, RuleEdit;
    return {
        setters: [function (_flarumApp) {
            app = _flarumApp.default;
        }, function (_flarumHelpersIcon) {
            icon = _flarumHelpersIcon.default;
        }, function (_flarumComponent) {
            Component = _flarumComponent.default;
        }, function (_flarumComponentsButton) {
            Button = _flarumComponentsButton.default;
        }, function (_flarumComponentsSelect) {
            Select = _flarumComponentsSelect.default;
        }],
        execute: function () {
            RuleEdit = function (_Component) {
                babelHelpers.inherits(RuleEdit, _Component);

                function RuleEdit() {
                    babelHelpers.classCallCheck(this, RuleEdit);
                    return babelHelpers.possibleConstructorReturn(this, (RuleEdit.__proto__ || Object.getPrototypeOf(RuleEdit)).apply(this, arguments));
                }

                babelHelpers.createClass(RuleEdit, [{
                    key: 'init',
                    value: function init() {
                        this.rule = this.props.rule;
                        this.dirty = false;
                        this.processing = false;
                        this.toggleFields = false;

                        if (this.rule === null) {
                            this.initNewField();
                        }
                    }
                }, {
                    key: 'initNewField',
                    value: function initNewField() {
                        this.rule = app.store.createRecord('flagrow-affiliation-links-rules', {
                            attributes: {
                                match_component: 'host',
                                match_type: 'exact',
                                match_pattern: '',
                                replacement: '',
                                comment: ''
                            }
                        });
                    }
                }, {
                    key: 'boxTitle',
                    value: function boxTitle() {
                        if (this.rule.exists) {
                            return [this.rule.match_pattern(), ' ', this.rule.comment() ? m('em', '(' + this.rule.comment().split('\n')[0] + ')') : null];
                        }

                        return app.translator.trans('flagrow-affiliation-links.admin.buttons.new-rule');
                    }
                }, {
                    key: 'view',
                    value: function view() {
                        var _this2 = this;

                        return m('.Flagrow-AffiliationLinks-Rule-Box', [this.rule.exists ? m('span.fa.fa-arrows.Flagrow-AffiliationLinks-Rule-Box--handle.js-rule-handle') : null, m('.Button.Button--block.Flagrow-AffiliationLinks-Rule-Header', {
                            onclick: function onclick() {
                                _this2.toggleFields = !_this2.toggleFields;
                            }
                        }, [m('.Flagrow-AffiliationLinks-Rule-Header-Title', this.boxTitle()), m('div', [this.rule.exists ? [app.translator.trans('flagrow-affiliation-links.admin.buttons.edit-rule'), ' '] : null, icon(this.toggleFields ? 'chevron-up' : 'chevron-down')])]), this.toggleFields ? this.viewFields() : null]);
                    }
                }, {
                    key: 'viewFields',
                    value: function viewFields() {
                        return m('form.Flagrow-AffiliationLinks-Rule-Body', [m('.Form-group', [m('label', app.translator.trans('flagrow-affiliation-links.admin.rules.match-component')), Select.component({
                            value: this.rule.match_component(),
                            onchange: this.updateAttribute.bind(this, 'match_component'),
                            options: {
                                uri: app.translator.trans('flagrow-affiliation-links.admin.component-options.uri'),
                                host: app.translator.trans('flagrow-affiliation-links.admin.component-options.host'),
                                path: app.translator.trans('flagrow-affiliation-links.admin.component-options.path')
                            }
                        }), m('.helpText', app.translator.trans('flagrow-affiliation-links.admin.rules.match-component-help'))]), m('.Form-group', [m('label', app.translator.trans('flagrow-affiliation-links.admin.rules.match-type')), Select.component({
                            value: this.rule.match_type(),
                            onchange: this.updateAttribute.bind(this, 'match_type'),
                            options: {
                                exact: app.translator.trans('flagrow-affiliation-links.admin.type-options.exact'),
                                simple: app.translator.trans('flagrow-affiliation-links.admin.type-options.simple'),
                                regex: app.translator.trans('flagrow-affiliation-links.admin.type-options.regex')
                            }
                        }), m('.helpText', app.translator.trans('flagrow-affiliation-links.admin.rules.match-type-help'))]), m('.Form-group', [m('label', app.translator.trans('flagrow-affiliation-links.admin.rules.match-pattern')), m('input.FormControl', {
                            type: 'text',
                            value: this.rule.match_pattern(),
                            oninput: m.withAttr('value', this.updateAttribute.bind(this, 'match_pattern'))
                        }), m('.helpText', app.translator.trans('flagrow-affiliation-links.admin.rules.match-pattern-help'))]), m('.Form-group', [m('label', app.translator.trans('flagrow-affiliation-links.admin.rules.replacement')), m('input.FormControl', {
                            type: 'text',
                            value: this.rule.replacement(),
                            oninput: m.withAttr('value', this.updateAttribute.bind(this, 'replacement'))
                        }), m('.helpText', app.translator.trans('flagrow-affiliation-links.admin.rules.replacement-help'))]), m('.Form-group', [m('label', app.translator.trans('flagrow-affiliation-links.admin.rules.comment')), m('textarea.FormControl', {
                            value: this.rule.comment(),
                            oninput: m.withAttr('value', this.updateAttribute.bind(this, 'comment'))
                        })]), m('.ButtonGroup', [Button.component({
                            type: 'submit',
                            className: 'Button Button--primary',
                            children: app.translator.trans('flagrow-affiliation-links.admin.buttons.' + (this.rule.exists ? 'save' : 'add') + '-rule'),
                            loading: this.processing,
                            disabled: !this.readyToSave(),
                            onclick: this.savePolicy.bind(this)
                        }), this.rule.exists ? Button.component({
                            type: 'submit',
                            className: 'Button Button--danger',
                            children: app.translator.trans('flagrow-affiliation-links.admin.buttons.delete-rule'),
                            loading: this.processing,
                            onclick: this.deletePolicy.bind(this)
                        }) : ''])]);
                    }
                }, {
                    key: 'updateAttribute',
                    value: function updateAttribute(attribute, value) {
                        this.rule.pushAttributes(babelHelpers.defineProperty({}, attribute, value));

                        this.dirty = true;
                    }
                }, {
                    key: 'readyToSave',
                    value: function readyToSave() {
                        return this.dirty;
                    }
                }, {
                    key: 'savePolicy',
                    value: function savePolicy() {
                        var _this3 = this;

                        this.processing = true;

                        var createNewRecord = !this.rule.exists;

                        this.rule.save(this.rule.data.attributes).then(function () {
                            if (createNewRecord) {
                                _this3.initNewField();
                                _this3.toggleFields = false;
                            }

                            _this3.processing = false;
                            _this3.dirty = false;

                            m.redraw();
                        }).catch(function (err) {
                            _this3.processing = false;

                            throw err;
                        });
                    }
                }, {
                    key: 'deletePolicy',
                    value: function deletePolicy() {
                        var _this4 = this;

                        if (!confirm(app.translator.trans('flagrow-affiliation-links.admin.messages.delete-rule-confirmation', {
                            name: this.rule.name()
                        }).join(''))) {
                            return;
                        }

                        this.processing = true;

                        this.rule.delete().then(function () {
                            _this4.processing = false;

                            m.redraw();
                        }).catch(function (err) {
                            _this4.processing = false;

                            throw err;
                        });
                    }
                }]);
                return RuleEdit;
            }(Component);

            _export('default', RuleEdit);
        }
    };
});;
'use strict';

System.register('flagrow/affiliation-links/components/RuleList', ['flarum/app', 'flarum/Component', 'flagrow/affiliation-links/components/RuleEdit', 'flagrow/affiliation-links/helpers/sortByAttribute'], function (_export, _context) {
    "use strict";

    var app, Component, RuleEdit, sortByAttribute, RuleList;
    return {
        setters: [function (_flarumApp) {
            app = _flarumApp.default;
        }, function (_flarumComponent) {
            Component = _flarumComponent.default;
        }, function (_flagrowAffiliationLinksComponentsRuleEdit) {
            RuleEdit = _flagrowAffiliationLinksComponentsRuleEdit.default;
        }, function (_flagrowAffiliationLinksHelpersSortByAttribute) {
            sortByAttribute = _flagrowAffiliationLinksHelpersSortByAttribute.default;
        }],
        execute: function () {
            RuleList = function (_Component) {
                babelHelpers.inherits(RuleList, _Component);

                function RuleList() {
                    babelHelpers.classCallCheck(this, RuleList);
                    return babelHelpers.possibleConstructorReturn(this, (RuleList.__proto__ || Object.getPrototypeOf(RuleList)).apply(this, arguments));
                }

                babelHelpers.createClass(RuleList, [{
                    key: 'init',
                    value: function init() {
                        app.request({
                            method: 'GET',
                            url: app.forum.attribute('apiUrl') + '/flagrow/affiliation-links/rules'
                        }).then(function (result) {
                            app.store.pushPayload(result);

                            m.redraw();
                        });
                    }
                }, {
                    key: 'config',
                    value: function config() {
                        var _this2 = this;

                        this.$('.js-rules-container').sortable({
                            handle: '.js-rule-handle'
                        }).on('sortupdate', function () {
                            var sorting = _this2.$('.js-rule-data').map(function () {
                                return $(this).data('id');
                            }).get();

                            _this2.updateSort(sorting);
                        });
                    }
                }, {
                    key: 'view',
                    value: function view() {
                        var rules = app.store.all('flagrow-affiliation-links-rules');

                        var fieldsList = [];

                        sortByAttribute(rules).forEach(function (rule) {
                            // Build array of fields to show.
                            fieldsList.push(m('.js-rule-data', {
                                key: rule.id(),
                                'data-id': rule.id()
                            }, RuleEdit.component({
                                rule: rule
                            })));
                        });

                        return m('div', [m('h2', app.translator.trans('flagrow-affiliation-links.admin.titles.rules')), m('.Flagrow-AffiliationLinks-Rules-Container', [m('.js-rules-container', fieldsList), RuleEdit.component({
                            key: 'new',
                            rule: null
                        })])]);
                    }
                }, {
                    key: 'updateSort',
                    value: function updateSort(sorting) {
                        app.request({
                            method: 'POST',
                            url: app.forum.attribute('apiUrl') + '/flagrow/affiliation-links/rules/order',
                            data: {
                                sort: sorting
                            }
                        }).then(function (result) {
                            // Update sort attributes
                            app.store.pushPayload(result);

                            m.redraw();
                        });
                    }
                }]);
                return RuleList;
            }(Component);

            _export('default', RuleList);
        }
    };
});;
'use strict';

System.register('flagrow/affiliation-links/helpers/sortByAttribute', [], function (_export, _context) {
    "use strict";

    _export('default', function (items) {
        var attr = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'sort';

        return items.sort(function (a, b) {
            return a[attr]() - b[attr]();
        });
    });

    return {
        setters: [],
        execute: function () {}
    };
});;
'use strict';

System.register('flagrow/affiliation-links/main', ['flarum/app', 'flagrow/affiliation-links/models/Rule', 'flagrow/affiliation-links/components/AffiliationSettingsModal'], function (_export, _context) {
    "use strict";

    var app, Rule, AffiliationSettingsModal;
    return {
        setters: [function (_flarumApp) {
            app = _flarumApp.default;
        }, function (_flagrowAffiliationLinksModelsRule) {
            Rule = _flagrowAffiliationLinksModelsRule.default;
        }, function (_flagrowAffiliationLinksComponentsAffiliationSettingsModal) {
            AffiliationSettingsModal = _flagrowAffiliationLinksComponentsAffiliationSettingsModal.default;
        }],
        execute: function () {

            app.initializers.add('flagrow-affiliation-links', function (app) {
                app.store.models['flagrow-affiliation-links-rules'] = Rule;

                app.extensionSettings['flagrow-affiliation-links'] = function () {
                    return app.modal.show(new AffiliationSettingsModal());
                };
            });
        }
    };
});;
'use strict';

System.register('flagrow/affiliation-links/models/Rule', ['flarum/Model', 'flarum/utils/mixin'], function (_export, _context) {
    "use strict";

    var Model, mixin, Rule;
    return {
        setters: [function (_flarumModel) {
            Model = _flarumModel.default;
        }, function (_flarumUtilsMixin) {
            mixin = _flarumUtilsMixin.default;
        }],
        execute: function () {
            Rule = function (_mixin) {
                babelHelpers.inherits(Rule, _mixin);

                function Rule() {
                    babelHelpers.classCallCheck(this, Rule);
                    return babelHelpers.possibleConstructorReturn(this, (Rule.__proto__ || Object.getPrototypeOf(Rule)).apply(this, arguments));
                }

                babelHelpers.createClass(Rule, [{
                    key: 'apiEndpoint',
                    value: function apiEndpoint() {
                        return '/flagrow/affiliation-links/rules' + (this.exists ? '/' + this.data.id : '');
                    }
                }]);
                return Rule;
            }(mixin(Model, {
                sort: Model.attribute('sort'),
                match_component: Model.attribute('match_component'),
                match_type: Model.attribute('match_type'),
                match_pattern: Model.attribute('match_pattern'),
                replacement: Model.attribute('replacement'),
                comment: Model.attribute('comment')
            }));

            _export('default', Rule);
        }
    };
});