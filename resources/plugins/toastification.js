import Vue from "vue";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

/**
 * @description toastification configuration
 */
Vue.use(Toast, {
    transition: "Vue-Toastification__bounce",
    newestOnTop: true,
    filterBeforeCreate: (toast, toasts) => {
        if (toasts.filter((t) => t.type === toast.type).length !== 0) {
            return false;
        }
        return toast;
    },
});

Vue.use(Toast);