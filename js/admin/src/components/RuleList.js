import app from 'flarum/app';
import Component from 'flarum/Component';
import RuleEdit from 'flagrow/affiliation-links/components/RuleEdit';
import sortByAttribute from 'flagrow/affiliation-links/helpers/sortByAttribute';

export default class RuleList extends Component {
    init() {
        app.request({
            method: 'GET',
            url: app.forum.attribute('apiUrl') + '/flagrow/affiliation-links/rules',
        }).then(result => {
            app.store.pushPayload(result);

            m.redraw();
        });
    }

    config() {
        this.$('.js-rules-container')
            .sortable({
                handle: '.js-rule-handle',
            })
            .on('sortupdate', () => {
                const sorting = this.$('.js-rule-data')
                    .map(function () {
                        return $(this).data('id');
                    })
                    .get();

                this.updateSort(sorting);
            });
    }

    view() {
        const rules = app.store.all('flagrow-affiliation-links-rules');

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
            m('h2', app.translator.trans('flagrow-affiliation-links.admin.titles.rules')),
            m('.Flagrow-AffiliationLinks-Rules-Container', [
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
            url: app.forum.attribute('apiUrl') + '/flagrow/affiliation-links/rules/order',
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
