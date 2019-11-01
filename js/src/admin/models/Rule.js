import Model from 'flarum/Model';
import mixin from 'flarum/utils/mixin';

export default class Rule extends mixin(Model, {
    sort: Model.attribute('sort'),
    match_component: Model.attribute('match_component'),
    match_type: Model.attribute('match_type'),
    match_pattern: Model.attribute('match_pattern'),
    replacement: Model.attribute('replacement'),
    comment: Model.attribute('comment'),
}) {
    /**
     * @inheritDoc
     */
    apiEndpoint() {
        return '/kilowhat-affiliation-links/rules' + (this.exists ? '/' + this.data.id : '');
    }
}
