
import InputField from './InputField.vue'
import PasswordField from './PasswordField.vue'
import SetField from './SetField.vue'
import TextField from './TextField.vue'
import SelectField from './SelectField.vue'
import ComboBox from './ComboBox.vue'
import OptionsTable from './OptionsTable.vue'
import SpecificsTable from './SpecificsTable.vue'
import RadioSet from './RadioSet.vue'
import CheckSet from './CheckSet.vue'

export default {
    install (Vue) {
        Vue.component('InputField', InputField)
        Vue.component('PasswordField', PasswordField)
        Vue.component('SetField', SetField)
        Vue.component('TextField', TextField)
        Vue.component('SelectField', SelectField)
        Vue.component('ComboBox', ComboBox)
        Vue.component('OptionsTable', OptionsTable)
        Vue.component('SpecificsTable', SpecificsTable)
        Vue.component('RadioSet', RadioSet)
        Vue.component('CheckSet', CheckSet)
    }
}