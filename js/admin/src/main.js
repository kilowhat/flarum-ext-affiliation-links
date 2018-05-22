import app from 'flarum/app';
import Rule from 'flagrow/affiliation-links/models/Rule';
import AffiliationSettingsModal from 'flagrow/affiliation-links/components/AffiliationSettingsModal';

app.initializers.add('flagrow-affiliation-links', app => {
    app.store.models['flagrow-affiliation-links-rules'] = Rule;

    app.extensionSettings['flagrow-affiliation-links'] = () => app.modal.show(new AffiliationSettingsModal());
});
