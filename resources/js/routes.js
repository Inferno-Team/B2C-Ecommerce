import Home from './layouts/Home.vue'
import HomePage from './pages/HomePage.vue'
import FavPage from './pages/FavPage.vue'
import CartPage from './pages/CartPage.vue'
import LoginPage from './pages/LoginPage.vue'
import SectionPage from './pages/SectionPage.vue'
import SignUpPage from './pages/SignUpPage.vue'
import AddProductPage from './pages/AddProductPage.vue'
import ProductPage from './pages/ProductPage.vue'
import EditProductPage from './pages/EditProductPage.vue'
import CheckoutPage from './pages/CheckoutPage.vue'
export const routes = [{
    path: '/',
    name: 'home',
    component: Home,
    children: [{
            path: '',
            name: 'home-page',
            component: HomePage
        },
        {
            path: '/login',
            name: 'login-page',
            component: LoginPage
        },
        {
            path: '/signup',
            name: 'signup-page',
            component: SignUpPage
        },
        {
            path: '/fav',
            name: 'fav-page',
            component: FavPage
        },
        {
            path: '/cart',
            name: 'cart-page',
            component: CartPage
        }, {
            path: '/add',
            name: 'add-page',
            component: AddProductPage
        },
        {
            path: '/section/:secName',
            name: 'section-page',
            component: SectionPage,
            props: true
        },
        {
            path: '/product/:id',
            name: 'product-page',
            component: ProductPage,
            props: true
        }, {
            path: '/checkout',
            name: 'checkout',
            component: CheckoutPage,
        }, {
            path: '/product/edit/:id',
            name: 'edit-product-page',
            component: EditProductPage,
            props: true
        },
    ]
}, ];