<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const uploading = ref(false);
const uploadingField = ref('');
const isDragging = ref(false);
const uploadProgress = ref(0);
const uploadError = ref('');

const mainInput = ref(null);
const image2Input = ref(null);
const image3Input = ref(null);

const resolveImage = (path) => {
    if (!path) return '';
    if (path.startsWith('/assets/') || path.startsWith('/storage/')) return path;
    if ((path.startsWith('http://') || path.startsWith('https://')) && path.includes('/storage/')) {
        return path.slice(path.indexOf('/storage/'));
    }
    if (path.startsWith('http://') || path.startsWith('https://')) return path;
    return `/storage/${path}`;
};

const imageName = (path) => path ? path.split('/').pop() : '';
const csrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

const stepRows = ref([]);
const benefitItems = ref([]);
const factRows = ref([]);

const showIconPicker = ref(false);
const iconSearch = ref('');

const ICONS = [
    { name: 'fa-seedling', label: 'Semence' },
    { name: 'fa-leaf', label: 'Feuille' },
    { name: 'fa-tree', label: 'Arbre' },
    { name: 'fa-spa', label: 'Nature' },
    { name: 'fa-tractor', label: 'Tracteur' },
    { name: 'fa-sun', label: 'Soleil' },
    { name: 'fa-cloud-rain', label: 'Pluie' },
    { name: 'fa-water', label: 'Eau' },
    { name: 'fa-mountain', label: 'Montagne' },
    { name: 'fa-wind', label: 'Vent' },
    { name: 'fa-industry', label: 'Industrie' },
    { name: 'fa-warehouse', label: 'Entrepôt' },
    { name: 'fa-cogs', label: 'Engrenages' },
    { name: 'fa-tools', label: 'Outils' },
    { name: 'fa-wrench', label: 'Clé' },
    { name: 'fa-flask', label: 'Labo' },
    { name: 'fa-microscope', label: 'Microscope' },
    { name: 'fa-fire', label: 'Chaleur' },
    { name: 'fa-hammer', label: 'Marteau' },
    { name: 'fa-layer-group', label: 'Niveaux' },
    { name: 'fa-truck', label: 'Camion' },
    { name: 'fa-shipping-fast', label: 'Livraison' },
    { name: 'fa-box', label: 'Boîte' },
    { name: 'fa-boxes', label: 'Stock' },
    { name: 'fa-pallet', label: 'Palette' },
    { name: 'fa-map-marker-alt', label: 'Localisation' },
    { name: 'fa-route', label: 'Route' },
    { name: 'fa-dolly', label: 'Chariot' },
    { name: 'fa-barcode', label: 'Code-barres' },
    { name: 'fa-certificate', label: 'Certificat' },
    { name: 'fa-award', label: 'Récompense' },
    { name: 'fa-star', label: 'Étoile' },
    { name: 'fa-medal', label: 'Médaille' },
    { name: 'fa-shield-alt', label: 'Sécurité' },
    { name: 'fa-check-circle', label: 'Validé' },
    { name: 'fa-clipboard-check', label: 'Checklist' },
    { name: 'fa-search', label: 'Contrôle' },
    { name: 'fa-balance-scale', label: 'Équilibre' },
    { name: 'fa-users', label: 'Équipe' },
    { name: 'fa-user-tie', label: 'Expert' },
    { name: 'fa-handshake', label: 'Partenariat' },
    { name: 'fa-hands-helping', label: 'Aide' },
    { name: 'fa-heart', label: 'Passion' },
    { name: 'fa-user-cog', label: 'Gestion' },
    { name: 'fa-chart-bar', label: 'Statistiques' },
    { name: 'fa-chart-line', label: 'Croissance' },
    { name: 'fa-chart-pie', label: 'Données' },
    { name: 'fa-tags', label: 'Étiquettes' },
    { name: 'fa-coins', label: 'Paiement' },
    { name: 'fa-money-bill-wave', label: 'Finance' },
    { name: 'fa-store', label: 'Marché' },
    { name: 'fa-shopping-cart', label: 'Panier' },
    { name: 'fa-phone', label: 'Téléphone' },
    { name: 'fa-envelope', label: 'Email' },
    { name: 'fa-headset', label: 'Support' },
    { name: 'fa-comments', label: 'Discussion' },
    { name: 'fa-concierge-bell', label: 'Service' },
    { name: 'fa-life-ring', label: 'Assistance' },
    { name: 'fa-graduation-cap', label: 'Formation' },
    { name: 'fa-book', label: 'Livre' },
    { name: 'fa-book-open', label: 'Guide' },
    { name: 'fa-lightbulb', label: 'Innovation' },
    { name: 'fa-chalkboard-teacher', label: 'Enseignement' },
    { name: 'fa-brain', label: 'Intelligence' },
    { name: 'fa-globe', label: 'International' },
    { name: 'fa-home', label: 'Local' },
    { name: 'fa-calendar-alt', label: 'Planning' },
    { name: 'fa-clock', label: 'Horaires' },
    { name: 'fa-recycle', label: 'Recyclage' },
    { name: 'fa-thermometer', label: 'Température' },
    { name: 'fa-weight', label: 'Poids' },
    { name: 'fa-ruler', label: 'Mesure' },
    { name: 'fa-archive', label: 'Archive' },
    { name: 'fa-solar-panel', label: 'Énergie' },
];

const filteredIcons = computed(() => {
    if (!iconSearch.value) return ICONS;
    const q = iconSearch.value.toLowerCase();
    return ICONS.filter(i => i.name.includes(q) || i.label.toLowerCase().includes(q));
});

const selectIcon = (name) => { form.icon = name; showIconPicker.value = false; iconSearch.value = ''; };

const form = useForm({
    slug: '',
    title: '',
    icon: '',
    short: '',
    description: '',
    description2: '',
    image: '',
    image2: '',
    image3: '',
});

const uploadFiles = async (files, field = 'image') => {
    const selected = Array.from(files || []).filter(f => f.type.startsWith('image/'));
    if (!selected.length) return;

    const payload = new FormData();
    selected.forEach(f => payload.append('images[]', f));

    uploading.value = true;
    uploadingField.value = field;
    uploadProgress.value = 0;
    uploadError.value = '';

    try {
        const res = await window.axios.post('/admin/services/upload-image', payload, {
            headers: { 'X-CSRF-TOKEN': csrfToken() },
            onUploadProgress: (e) => {
                if (e.total) uploadProgress.value = Math.round((e.loaded / e.total) * 100);
            },
        });
        if (res.data.images?.[0]) form[field] = res.data.images[0];
    } catch (err) {
        const msg = err.response?.data?.message || err.response?.data?.error;
        uploadError.value = msg || 'Echec de l\'import. Vérifiez le format ou la taille (max 4 Mo).';
    } finally {
        uploading.value = false;
        uploadingField.value = '';
        uploadProgress.value = 0;
    }
};

const handleDragEnter = (e) => { e.preventDefault(); isDragging.value = true; };
const handleDragLeave = (e) => { if (!e.currentTarget.contains(e.relatedTarget)) isDragging.value = false; };
const handleDrop = (e) => { isDragging.value = false; uploadFiles(e.dataTransfer.files, 'image'); };

const addStep = () => stepRows.value.push({ num: String(stepRows.value.length + 1).padStart(2, '0'), title: '', text: '' });
const removeStep = (i) => stepRows.value.splice(i, 1);

const addBenefit = () => benefitItems.value.push('');
const removeBenefit = (i) => benefitItems.value.splice(i, 1);

const addFact = () => factRows.value.push({ value: '', label: '' });
const removeFact = (i) => factRows.value.splice(i, 1);

const submit = () => {
    form
        .transform(data => ({
            ...data,
            icon: data.icon || null,
            description2: data.description2 || null,
            image2: data.image2 || null,
            image3: data.image3 || null,
            steps: stepRows.value.filter(s => s.title || s.text),
            benefits: benefitItems.value.map(b => String(b).trim()).filter(Boolean),
            facts: factRows.value.filter(f => f.value || f.label),
        }))
        .post('/admin/services');
};
</script>

<template>
    <Head title="Ajouter un Service" />

    <AdminLayout title="Ajouter un Service">
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <p class="eyebrow">Nouveau</p>
                    <h1>Ajouter un Service</h1>
                </div>
                <Link href="/admin/services" class="btn-secondary">
                    <i class="far fa-arrow-left"></i> Retour
                </Link>
            </div>

            <form @submit.prevent="submit" class="product-form">
                <div class="form-grid-layout">
                    <div class="form-main">

                        <section class="form-card">
                            <div class="card-header">
                                <h2>Informations générales</h2>
                            </div>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Slug *</label>
                                    <input v-model="form.slug" type="text" required placeholder="collecte-riz">
                                    <span v-if="form.errors.slug" class="error">{{ form.errors.slug }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Titre *</label>
                                    <input v-model="form.title" type="text" required placeholder="Collecte de Riz Paddy">
                                    <span v-if="form.errors.title" class="error">{{ form.errors.title }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Icone <small>(cliquer sur la grille pour choisir)</small></label>
                                <div class="icon-field">
                                    <div class="icon-preview-box" :class="{ active: showIconPicker }" @click="showIconPicker = !showIconPicker" :title="form.icon || 'Choisir une icône'">
                                        <i :class="['fas', form.icon || 'fa-icons']"></i>
                                    </div>
                                    <input v-model="form.icon" type="text" placeholder="fa-seedling" @focus="showIconPicker = true">
                                    <button type="button" class="btn-soft icon-pick-toggle" @click="showIconPicker = !showIconPicker" :title="showIconPicker ? 'Fermer' : 'Choisir'">
                                        <i class="fas" :class="showIconPicker ? 'fa-times' : 'fa-th'"></i>
                                    </button>
                                </div>

                                <div v-if="showIconPicker" class="icon-picker" @click.stop>
                                    <div class="icon-picker-header">
                                        <i class="fas fa-search icon-search-icon"></i>
                                        <input v-model="iconSearch" type="text" class="icon-search" placeholder="Rechercher… (ex: camion, qualité)">
                                        <button type="button" class="icon-picker-close" @click="showIconPicker = false"><i class="fas fa-times"></i></button>
                                    </div>
                                    <div class="icon-picker-grid">
                                        <button
                                            v-for="icon in filteredIcons" :key="icon.name"
                                            type="button" class="icon-option"
                                            :class="{ active: form.icon === icon.name }"
                                            @click="selectIcon(icon.name)" :title="icon.label"
                                        >
                                            <i :class="['fas', icon.name]"></i>
                                            <span>{{ icon.label }}</span>
                                        </button>
                                        <p v-if="filteredIcons.length === 0" class="icon-picker-empty">Aucun résultat pour "{{ iconSearch }}"</p>
                                    </div>
                                    <div class="icon-picker-footer">
                                        <span v-if="form.icon">Sélectionné : <strong>{{ form.icon }}</strong></span>
                                        <button v-if="form.icon" type="button" class="btn-soft small" @click="form.icon = ''; showIconPicker = false">
                                            <i class="fas fa-times"></i> Retirer l'icône
                                        </button>
                                    </div>
                                </div>
                                <div v-if="showIconPicker" class="icon-picker-backdrop" @click="showIconPicker = false"></div>

                                <span v-if="form.errors.icon" class="error">{{ form.errors.icon }}</span>
                            </div>

                            <div class="form-group">
                                <label>Description courte *</label>
                                <textarea v-model="form.short" rows="3" required placeholder="Résumé du service en une ou deux phrases"></textarea>
                                <span v-if="form.errors.short" class="error">{{ form.errors.short }}</span>
                            </div>

                            <div class="form-group">
                                <label>Description principale *</label>
                                <textarea v-model="form.description" rows="6" required placeholder="Description complète et détaillée du service"></textarea>
                                <span v-if="form.errors.description" class="error">{{ form.errors.description }}</span>
                            </div>

                            <div class="form-group">
                                <label>Description complémentaire</label>
                                <textarea v-model="form.description2" rows="4" placeholder="Paragraphe additionnel (optionnel)"></textarea>
                            </div>
                        </section>

                        <!-- Images -->
                        <section class="form-card">
                            <div class="card-header">
                                <h2>Images</h2>
                            </div>

                            <div class="form-group">
                                <label>Image principale *</label>
                                <div class="main-image-editor">
                                    <img v-if="form.image" :src="resolveImage(form.image)" alt="Image principale">
                                    <div v-else class="image-placeholder">
                                        <i class="far fa-image"></i>
                                        <span>Aucune image</span>
                                    </div>
                                    <div class="main-image-fields">
                                        <input v-model="form.image" type="hidden" required>
                                        <div class="image-path-display">
                                            <i class="far fa-image"></i>
                                            <span v-if="form.image" :title="form.image">{{ imageName(form.image) }}</span>
                                            <span v-else class="placeholder-text">Aucune image sélectionnée</span>
                                        </div>
                                        <button type="button" class="btn-soft" @click="mainInput.click()">
                                            <i class="far fa-upload"></i> Importer image principale
                                        </button>
                                    </div>
                                </div>

                                <div
                                    class="upload-zone"
                                    :class="{ uploading: uploading && uploadingField === 'image', dragging: isDragging }"
                                    @dragenter="handleDragEnter"
                                    @dragover.prevent
                                    @dragleave="handleDragLeave"
                                    @drop.prevent="handleDrop"
                                >
                                    <i class="far" :class="isDragging ? 'fa-arrow-down' : 'fa-images'"></i>
                                    <strong>{{ isDragging ? 'Relâcher pour importer' : 'Glisser-déposer ici' }}</strong>
                                    <span v-if="!isDragging">ou cliquer sur le bouton ci-dessus</span>
                                </div>

                                <input ref="mainInput" class="file-input" type="file" accept="image/*"
                                    @change="uploadFiles($event.target.files, 'image'); $event.target.value = ''">

                                <div v-if="uploading && uploadingField === 'image'" class="upload-progress">
                                    <div class="progress-bar" :style="{ width: uploadProgress + '%' }"></div>
                                    <span>Import{{ uploadProgress ? ` — ${uploadProgress}%` : '...' }}</span>
                                </div>
                                <span v-if="form.errors.image" class="error">{{ form.errors.image }}</span>
                            </div>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Image 2 <small>(optionnelle)</small></label>
                                    <div class="mini-image-slot">
                                        <img v-if="form.image2" :src="resolveImage(form.image2)" alt="Image 2">
                                        <div v-else class="mini-placeholder"><i class="far fa-image"></i></div>
                                        <div class="mini-slot-actions">
                                            <div class="image-path-display small">
                                                <i class="far fa-image"></i>
                                                <span v-if="form.image2" :title="form.image2">{{ imageName(form.image2) }}</span>
                                                <span v-else class="placeholder-text">Non définie</span>
                                            </div>
                                            <button type="button" class="btn-soft" @click="image2Input.click()">
                                                <i class="far fa-upload"></i> Importer
                                            </button>
                                        </div>
                                    </div>
                                    <input ref="image2Input" class="file-input" type="file" accept="image/*"
                                        @change="uploadFiles($event.target.files, 'image2'); $event.target.value = ''">
                                    <div v-if="uploading && uploadingField === 'image2'" class="upload-progress">
                                        <div class="progress-bar" :style="{ width: uploadProgress + '%' }"></div>
                                        <span>Import{{ uploadProgress ? ` — ${uploadProgress}%` : '...' }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Image 3 <small>(optionnelle)</small></label>
                                    <div class="mini-image-slot">
                                        <img v-if="form.image3" :src="resolveImage(form.image3)" alt="Image 3">
                                        <div v-else class="mini-placeholder"><i class="far fa-image"></i></div>
                                        <div class="mini-slot-actions">
                                            <div class="image-path-display small">
                                                <i class="far fa-image"></i>
                                                <span v-if="form.image3" :title="form.image3">{{ imageName(form.image3) }}</span>
                                                <span v-else class="placeholder-text">Non définie</span>
                                            </div>
                                            <button type="button" class="btn-soft" @click="image3Input.click()">
                                                <i class="far fa-upload"></i> Importer
                                            </button>
                                        </div>
                                    </div>
                                    <input ref="image3Input" class="file-input" type="file" accept="image/*"
                                        @change="uploadFiles($event.target.files, 'image3'); $event.target.value = ''">
                                    <div v-if="uploading && uploadingField === 'image3'" class="upload-progress">
                                        <div class="progress-bar" :style="{ width: uploadProgress + '%' }"></div>
                                        <span>Import{{ uploadProgress ? ` — ${uploadProgress}%` : '...' }}</span>
                                    </div>
                                </div>
                            </div>

                            <p v-if="uploadError" class="error">{{ uploadError }}</p>
                        </section>

                        <!-- Étapes -->
                        <section class="form-card">
                            <div class="card-header"><h2>Étapes du service</h2></div>
                            <div class="form-group">
                                <div class="label-row">
                                    <label>Étapes</label>
                                    <button type="button" class="btn-soft small" @click="addStep">
                                        <i class="far fa-plus"></i> Ajouter
                                    </button>
                                </div>
                                <div class="editable-list">
                                    <div v-for="(step, i) in stepRows" :key="i" class="step-row">
                                        <input v-model="step.num" type="text" placeholder="01" class="step-num">
                                        <input v-model="step.title" type="text" placeholder="Titre de l'étape">
                                        <input v-model="step.text" type="text" placeholder="Description de l'étape">
                                        <button type="button" class="icon-button danger" @click="removeStep(i)">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </div>
                                    <p v-if="stepRows.length === 0" class="empty-inline">Aucune étape ajoutée.</p>
                                </div>
                            </div>
                        </section>

                        <!-- Avantages et Faits -->
                        <section class="form-card">
                            <div class="card-header"><h2>Avantages et chiffres clés</h2></div>

                            <div class="form-group">
                                <div class="label-row">
                                    <label>Avantages</label>
                                    <button type="button" class="btn-soft small" @click="addBenefit">
                                        <i class="far fa-plus"></i> Ajouter
                                    </button>
                                </div>
                                <div class="editable-list">
                                    <div v-for="(benefit, i) in benefitItems" :key="i" class="editable-row feature-row">
                                        <input v-model="benefitItems[i]" type="text" placeholder="Ex: Prix transparents pour les producteurs">
                                        <button type="button" class="icon-button danger" @click="removeBenefit(i)">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </div>
                                    <p v-if="benefitItems.length === 0" class="empty-inline">Aucun avantage ajouté.</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="label-row">
                                    <label>Chiffres clés</label>
                                    <button type="button" class="btn-soft small" @click="addFact">
                                        <i class="far fa-plus"></i> Ajouter
                                    </button>
                                </div>
                                <div class="editable-list">
                                    <div v-for="(fact, i) in factRows" :key="i" class="editable-row">
                                        <input v-model="fact.value" type="text" placeholder="Ex: 30+">
                                        <input v-model="fact.label" type="text" placeholder="Ex: Producteurs partenaires">
                                        <button type="button" class="icon-button danger" @click="removeFact(i)">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </div>
                                    <p v-if="factRows.length === 0" class="empty-inline">Aucun chiffre clé ajouté.</p>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- Sidebar -->
                    <aside class="form-side">
                        <section class="preview-card">
                            <img v-if="form.image" :src="resolveImage(form.image)" alt="Aperçu">
                            <div v-else class="preview-placeholder">
                                <i class="far fa-image"></i>
                                <span>Aucune image</span>
                            </div>
                            <div class="preview-body">
                                <span class="preview-icon">
                                    <i :class="['fas', form.icon || 'fa-concierge-bell']"></i>
                                </span>
                                <h3>{{ form.title || 'Titre du service' }}</h3>
                                <p>{{ form.short || 'Description courte.' }}</p>
                                <div class="preview-counts">
                                    <span><strong>{{ stepRows.length }}</strong> étapes</span>
                                    <span><strong>{{ benefitItems.length }}</strong> avantages</span>
                                    <span><strong>{{ factRows.length }}</strong> chiffres</span>
                                </div>
                            </div>
                        </section>
                    </aside>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary" :disabled="form.processing">
                        <i class="far fa-save"></i>
                        {{ form.processing ? 'Enregistrement...' : 'Créer le service' }}
                    </button>
                    <Link href="/admin/services" class="btn-secondary">Annuler</Link>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<style scoped>
.admin-page { display: flex; flex-direction: column; gap: 24px; }

.page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 20px; }
.eyebrow { margin: 0 0 6px; color: #5cb85c; font-weight: 800; text-transform: uppercase; font-size: 0.78rem; }
.page-header h1 { margin: 0; color: #17351a; font-size: 1.85rem; font-weight: 900; }

.product-form { display: flex; flex-direction: column; gap: 22px; }

.form-grid-layout {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 340px;
    gap: 24px;
    align-items: start;
}

.form-main, .form-side { display: grid; gap: 22px; }

.form-card, .preview-card {
    background: #fff;
    border: 1px solid #e5ece2;
    border-radius: 8px;
    box-shadow: 0 16px 42px rgba(23, 53, 26, 0.06);
}

.form-card { padding: 26px; }

.card-header { display: flex; justify-content: space-between; gap: 14px; margin-bottom: 22px; }
.card-header h2 { margin: 0; color: #17351a; font-size: 1.1rem; font-weight: 900; }

.form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px; }

.form-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 18px; }
.form-group:last-child { margin-bottom: 0; }
.form-group label { color: #17351a; font-weight: 850; font-size: 0.9rem; }
.form-group label small { font-weight: 500; color: #68746a; }

.form-group input, .form-group textarea {
    width: 100%; padding: 12px 14px;
    border: 1.5px solid #dfe8db; border-radius: 6px;
    color: #17351a; font: inherit;
}

.form-group textarea { resize: vertical; }

.form-group input:focus, .form-group textarea:focus {
    outline: none; border-color: #5cb85c;
    box-shadow: 0 0 0 3px rgba(92, 184, 92, 0.14);
}

.icon-field { display: grid; grid-template-columns: 46px 1fr 42px; gap: 8px; align-items: center; position: relative; }

.icon-preview-box {
    width: 46px; height: 46px; border-radius: 8px;
    border: 1.5px solid #dfe8db; background: #f0faf0;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: #5cb85c; font-size: 1.25rem;
    transition: all 0.15s;
}
.icon-preview-box:hover, .icon-preview-box.active { border-color: #5cb85c; background: #e4f5e4; }

.icon-pick-toggle { width: 42px; padding: 0; }

.icon-picker-backdrop {
    position: fixed; inset: 0; z-index: 99;
}

.icon-picker {
    position: relative; z-index: 100;
    margin-top: 8px; border: 1.5px solid #c3ddc0;
    border-radius: 10px; background: #fff;
    box-shadow: 0 12px 36px rgba(23, 53, 26, 0.14);
    overflow: hidden;
}

.icon-picker-header {
    display: flex; align-items: center; gap: 8px;
    padding: 10px 12px; border-bottom: 1px solid #e5ece2;
    background: #f8faf7;
}

.icon-search-icon { color: #9aaa95; font-size: 0.9rem; flex-shrink: 0; }

.icon-search {
    flex: 1; padding: 8px 10px; border: 1.5px solid #dfe8db;
    border-radius: 6px; font: inherit; font-size: 0.9rem;
    color: #17351a;
}
.icon-search:focus { outline: none; border-color: #5cb85c; box-shadow: 0 0 0 3px rgba(92,184,92,0.12); }

.icon-picker-close {
    width: 34px; height: 34px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    border: 1px solid #dfe8db; border-radius: 6px;
    background: #fff; color: #68746a; cursor: pointer;
}
.icon-picker-close:hover { background: #fff5f5; border-color: #ffd4d4; color: #b42323; }

.icon-picker-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(72px, 1fr));
    gap: 4px; padding: 10px; max-height: 280px; overflow-y: auto;
}

.icon-option {
    display: flex; flex-direction: column; align-items: center; gap: 5px;
    padding: 10px 4px; border: 1.5px solid transparent; border-radius: 7px;
    background: transparent; cursor: pointer; text-align: center; transition: all 0.12s;
}
.icon-option:hover { background: #f0faf0; border-color: #c3ddc0; }
.icon-option.active { background: #e0f2e0; border-color: #5cb85c; }
.icon-option.active i { color: #24782b; }
.icon-option i { font-size: 1.3rem; color: #5cb85c; }
.icon-option span { font-size: 0.7rem; color: #68746a; font-weight: 600; line-height: 1.2; word-break: break-word; }

.icon-picker-empty { grid-column: 1/-1; margin: 0; padding: 20px; text-align: center; color: #9aaa95; font-style: italic; }

.icon-picker-footer {
    display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;
    padding: 10px 14px; border-top: 1px solid #e5ece2; background: #f8faf7;
    font-size: 0.85rem; color: #68746a;
}
.icon-picker-footer strong { color: #17351a; }

.main-image-editor {
    display: grid; grid-template-columns: 170px 1fr;
    gap: 16px; align-items: center; margin-bottom: 12px;
}

.main-image-editor img, .image-placeholder {
    width: 170px; height: 130px;
    border-radius: 8px; border: 1px solid #e5ece2; background: #f8faf7;
}

.main-image-editor img { object-fit: cover; }

.image-placeholder, .preview-placeholder, .mini-placeholder {
    display: grid; place-items: center; align-content: center;
    gap: 8px; color: #68746a; text-align: center;
}

.image-placeholder i, .preview-placeholder i, .mini-placeholder i { color: #9aaa95; font-size: 1.6rem; }

.main-image-fields { display: grid; gap: 10px; }

.image-path-display {
    display: flex; align-items: center; gap: 10px;
    padding: 11px 14px; border: 1.5px solid #dfe8db; border-radius: 6px;
    background: #f8faf7; color: #17351a; font-size: 0.95rem; min-height: 46px;
}

.image-path-display.small { min-height: 38px; font-size: 0.88rem; padding: 8px 12px; }
.image-path-display i { color: #5cb85c; font-size: 1.1rem; flex-shrink: 0; }
.image-path-display span { font-weight: 600; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.image-path-display .placeholder-text { color: #9aaa95; font-weight: 400; font-style: italic; }

.upload-zone {
    display: grid; place-items: center; gap: 8px;
    padding: 20px 18px; border: 2px dashed #cfe0c9;
    border-radius: 8px; background: #fbfcfa;
    text-align: center; color: #68746a;
}

.upload-zone.uploading { opacity: 0.65; pointer-events: none; }
.upload-zone.dragging { border-color: #5cb85c; background: #f0faf0; }
.upload-zone.dragging i, .upload-zone.dragging strong { color: #24782b; }
.upload-zone > i { color: #5cb85c; font-size: 1.6rem; }
.upload-zone strong { color: #17351a; font-size: 0.95rem; }
.upload-zone span { font-size: 0.85rem; }

.upload-progress {
    position: relative; height: 28px; background: #e8eee3;
    border-radius: 6px; overflow: hidden; margin-top: 8px;
    display: flex; align-items: center; padding: 0 12px;
}

.progress-bar {
    position: absolute; left: 0; top: 0; height: 100%;
    background: #5cb85c; transition: width 0.2s; z-index: 0;
}

.upload-progress span { position: relative; z-index: 1; font-size: 0.83rem; font-weight: 700; color: #17351a; }

.mini-image-slot { display: grid; grid-template-columns: 100px 1fr; gap: 12px; align-items: start; }

.mini-image-slot img, .mini-placeholder {
    width: 100px; height: 80px;
    border-radius: 6px; border: 1px solid #e5ece2; background: #f8faf7; object-fit: cover;
}

.mini-slot-actions { display: flex; flex-direction: column; gap: 8px; }

.file-input { display: none; }

.label-row { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 12px; }

.btn-soft, .icon-button {
    display: inline-flex; align-items: center; justify-content: center;
    gap: 7px; min-height: 38px; padding: 8px 12px;
    border: 1px solid #dfe8db; border-radius: 6px;
    background: #fff; color: #17351a; font-weight: 850;
    cursor: pointer; transition: all 0.2s;
}

.btn-soft:hover, .icon-button:hover { border-color: #5cb85c; background: #fbfcfa; }
.btn-soft.small { min-height: 32px; padding: 5px 10px; font-size: 0.85rem; }

.editable-list { display: grid; gap: 10px; }

.editable-row {
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(0, 1.4fr) 42px;
    gap: 10px; align-items: center;
}

.editable-row.feature-row { grid-template-columns: minmax(0, 1fr) 42px; }

.step-row {
    display: grid;
    grid-template-columns: 52px minmax(0, 1fr) minmax(0, 1.4fr) 42px;
    gap: 10px; align-items: center;
}

.step-num { text-align: center; font-weight: 700; color: #5cb85c; }

.icon-button { width: 42px; min-height: 42px; padding: 0; }
.icon-button.danger { color: #b42323; border-color: #ffd4d4; }

.empty-inline {
    margin: 0; padding: 14px;
    border: 1px dashed #dfe8db; border-radius: 6px;
    color: #68746a; background: #fbfcfa;
}

.preview-card { overflow: hidden; }
.preview-card img, .preview-placeholder { width: 100%; height: 200px; }
.preview-card img { object-fit: cover; }
.preview-placeholder { background: #f8faf7; border-bottom: 1px solid #e5ece2; }

.preview-body { padding: 18px; }

.preview-icon {
    display: flex; align-items: center; justify-content: center;
    width: 44px; height: 44px; border-radius: 50%;
    background: #f0faf0; margin-bottom: 12px;
}

.preview-icon i { color: #5cb85c; font-size: 1.2rem; }

.preview-body h3 { margin: 0 0 8px; color: #17351a; font-size: 1.05rem; font-weight: 900; }
.preview-body p { margin: 0 0 16px; color: #68746a; font-size: 0.9rem; }

.preview-counts { display: flex; gap: 12px; flex-wrap: wrap; }
.preview-counts span { font-size: 0.82rem; color: #68746a; }
.preview-counts strong { color: #5cb85c; }

.error { color: #b42323; font-weight: 750; font-size: 0.86rem; }

.form-actions {
    display: flex; flex-wrap: wrap; gap: 10px; justify-content: flex-end;
    padding: 18px; background: #fff;
    border: 1px solid #e5ece2; border-radius: 8px;
}

.btn-primary, .btn-secondary {
    display: inline-flex; align-items: center; justify-content: center;
    gap: 8px; min-height: 42px; padding: 10px 16px;
    border-radius: 6px; text-decoration: none; font-weight: 850;
}

.btn-primary { background: #5cb85c; color: #fff; border: none; cursor: pointer; }
.btn-primary:hover:not(:disabled) { background: #4a9e4a; }
.btn-primary:disabled { opacity: 0.6; cursor: not-allowed; }
.btn-secondary { background: #fff; color: #17351a; border: 1.5px solid #dfe8db; }
.btn-secondary:hover { border-color: #5cb85c; background: #fbfcfa; }

@media (max-width: 1100px) { .form-grid-layout { grid-template-columns: 1fr; } }

@media (max-width: 768px) {
    .page-header, .form-actions { flex-direction: column; align-items: flex-start; }
    .form-grid, .main-image-editor, .mini-image-slot, .step-row, .editable-row { grid-template-columns: 1fr; }
    .form-card { padding: 18px; }
    .main-image-editor img, .image-placeholder { width: 100%; height: 160px; }
}
</style>
