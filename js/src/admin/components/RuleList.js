import sortable from 'html5sortable/dist/html5sortable.es.js';
import app from 'flarum/app';
import Component from 'flarum/Component';
import sortByAttribute from '../helpers/sortByAttribute';
import RuleEdit from './RuleEdit';

/* global m, $ */

export default class RuleList extends Component {
    init() {
        app.request({
            method: 'GET',
            url: app.forum.attribute('apiUrl') + '/kilowhat-affiliation-links/rules',
        }).then(result => {
            app.store.pushPayload(result);

            m.redraw();
        });
    }

    config() {
        sortable(this.element.querySelector('.js-rules-container'), {
            handle: '.js-rule-handle',
        })[0].addEventListener('sortupdate', () => {
            const sorting = this.$('.js-rule-data')
                .map(function () {
                    return $(this).data('id');
                })
                .get();

            this.updateSort(sorting);
        });
    }

    view() {
        const rules = app.store.all('kilowhat-affiliation-links-rules');

        let fieldsList = [];

        sortByAttribute(rules)
            .forEach(rule => {
                // Build array of fields to show.
                fieldsList.push(m('.js-rule-data', {
                    key: rule.id(),
                    'data-id': rule.id(),
                }, RuleEdit.component({
                    rule,
                })));
            });

        return m('div', [
            m('h2', app.translator.trans('kilowhat-affiliation-links.admin.titles.rules')),
            m('.Kilowhat-AffiliationLinks-Rules-Container', [
                m('.js-rules-container', fieldsList),
                RuleEdit.component({
                    key: 'new',
                    rule: null,
                }),
            ]),
        ]);
    }

    updateSort(sorting) {
        app.request({
            method: 'POST',
            url: app.forum.attribute('apiUrl') + '/kilowhat-affiliation-links/rules/order',
            data: {
                sort: sorting,
            },
        }).then(result => {
            // Update sort attributes
            app.store.pushPayload(result);

            m.redraw();
        });
    }
}
