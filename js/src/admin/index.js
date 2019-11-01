import app from 'flarum/app';
import Rule from './models/Rule';
import AffiliationSettingsModal from './components/AffiliationSettingsModal';

app.initializers.add('kilowhat-affiliation-links', app => {
    app.store.models['kilowhat-affiliation-links-rules'] = Rule;

    app.extensionSettings['kilowhat-affiliation-links'] = () => app.modal.show(new AffiliationSettingsModal());
});
