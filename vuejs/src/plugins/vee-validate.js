import Vue from 'vue'
import {
    ValidationObserver,
    ValidationProvider,
} from "vee-validate";

Vue.component("ValidationObserver", ValidationObserver);
Vue.component("ValidationProvider", ValidationProvider);

import './../validators';

const ValidationState = {
    install(Vue) {
        Vue.prototype.getValidationState = ({ dirty, validated, valid = null }) => {
            return dirty || validated ? valid : null;
        }
    }
}

Vue.use(ValidationState)
