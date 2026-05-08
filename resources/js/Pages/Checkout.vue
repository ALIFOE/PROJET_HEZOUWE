<template>
    <AppLayout title="Finaliser la commande">
        <section class="breadcrumb-wrapper bg-cover fix" style="background-image: url('/assets/img/inner-page/breadcroumb.jpg');">
            <div class="shape-1 float-bob-y">
                <img src="/assets/img/inner-page/shape-1.png" alt="img">
            </div>
            <div class="shape-2 float-bob-x">
                <img src="/assets/img/inner-page/shape-2.png" alt="img">
            </div>
            <div class="container">
                <div class="page-heading">
                    <ul class="breadcrumb-list wow fadeInUp">
                        <li><Link href="/">Accueil</Link></li>
                        <li>//</li>
                        <li><Link href="/shop-cart">Mon Panier</Link></li>
                        <li>//</li>
                        <li>Commande</li>
                    </ul>
                    <h1 class="breadcrumb-title text-anim">Finaliser la commande</h1>
                </div>
            </div>
        </section>

        <section class="checkout-section section-padding fix">
            <div class="container">
                <div class="checkout-wrapper">
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="checkout-form">
                                <h3>Informations de livraison</h3>
                                <form @submit.prevent="submitOrder">
                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <input v-model="form.customer_name" type="text" placeholder="Nom complet" required>
                                            <InputError :message="form.errors.customer_name" />
                                        </div>
                                        <div class="col-lg-6">
                                            <input v-model="form.customer_email" type="email" placeholder="Email" required>
                                            <InputError :message="form.errors.customer_email" />
                                        </div>
                                        <div class="col-lg-6">
                                            <input v-model="form.customer_phone" type="tel" placeholder="Telephone" required>
                                            <InputError :message="form.errors.customer_phone" />
                                        </div>
                                        <div class="col-lg-6">
                                            <input v-model="form.city" type="text" placeholder="Ville" required>
                                            <InputError :message="form.errors.city" />
                                        </div>
                                        <div class="col-lg-12">
                                            <input v-model="form.address" type="text" placeholder="Adresse complete" required>
                                            <InputError :message="form.errors.address" />
                                        </div>
                                        <div class="col-lg-12">
                                            <textarea v-model="form.notes" rows="4" placeholder="Notes de livraison"></textarea>
                                            <InputError :message="form.errors.notes" />
                                        </div>
                                        <div class="col-lg-12">
                                            <select v-model="form.payment_method" required>
                                                <option value="cash_on_delivery">Paiement a la livraison</option>
                                                <option value="mobile_money">Mobile Money</option>
                                                <option value="bank_transfer">Virement bancaire</option>
                                            </select>
                                            <InputError :message="form.errors.payment_method" />
                                        </div>
                                    </div>

                                    <button type="submit" class="theme-btn mt-4" :disabled="form.processing">
                                        Confirmer la commande <i class="far fa-arrow-right"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="checkout-summary">
                                <h3>Resume de la commande</h3>

                                <div v-for="item in cartItems" :key="item.slug" class="summary-product">
                                    <img :src="item.image" :alt="item.title">
                                    <div>
                                        <strong>{{ item.title }}</strong>
                                        <span>{{ item.qty }} x {{ formatPrice(item.price) }} FCFA</span>
                                    </div>
                                </div>

                                <div class="summary-item">
                                    <span>Sous-total:</span>
                                    <span>{{ formatPrice(summary.subtotal) }} FCFA</span>
                                </div>
                                <div class="summary-item">
                                    <span>Livraison:</span>
                                    <span>{{ summary.delivery_cost === 0 ? 'Gratuite' : `${formatPrice(summary.delivery_cost)} FCFA` }}</span>
                                </div>
                                <div class="summary-item total">
                                    <span>Total:</span>
                                    <span>{{ formatPrice(summary.total) }} FCFA</span>
                                </div>

                                <Link href="/shop-cart" class="checkout-back">Modifier mon panier</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
    cartItems: Array,
    summary: Object,
});

const page = usePage();
const user = page.props.auth.user;

const form = useForm({
    customer_name: user?.name || '',
    customer_email: user?.email || '',
    customer_phone: '',
    city: '',
    address: '',
    notes: '',
    payment_method: 'cash_on_delivery',
});

const formatPrice = (n) => n?.toLocaleString('fr-FR') ?? '0';

const submitOrder = () => {
    form.post(route('orders.store'));
};
</script>

<style scoped>
.checkout-form textarea,
.checkout-form select {
    width: 100%;
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    padding: 14px 18px;
    outline: none;
}

.summary-product {
    display: flex;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #f0f0f0;
}

.summary-product img {
    width: 54px;
    height: 54px;
    border-radius: 8px;
    object-fit: cover;
}

.summary-product strong,
.summary-product span {
    display: block;
}

.summary-product strong {
    color: #1a3a1a;
    font-size: .9rem;
    line-height: 1.35;
}

.summary-product span {
    color: #777;
    font-size: .82rem;
    margin-top: 4px;
}

.checkout-back {
    display: inline-flex;
    margin-top: 16px;
    color: #2d7a2d;
    font-weight: 700;
    text-decoration: none;
}
</style>
