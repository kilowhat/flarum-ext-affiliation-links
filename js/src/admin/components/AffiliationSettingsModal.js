import app from 'flarum/app';
import SettingsModal from 'flarum/components/SettingsModal';
import RuleList from './RuleList';

export default class AffiliationSettingsModal extends SettingsModal {
    title() {
        return app.translator.trans('kilowhat-affiliation-links.admin.settings.title');
    }

    form() {
        return [
            RuleList.component(),
        ];
    }
}
