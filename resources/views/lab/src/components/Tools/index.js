
import VTooltip from './VTooltip.vue'
import ResizeBarVertical from "./ResizeBarVertical.vue";
import ResizeBarHorizontal from "./ResizeBarHorizontal.vue";

export default {
    install (Vue) {
        Vue.component('VTooltip', VTooltip)
        Vue.component('ResizeBarVertical', ResizeBarVertical)
        Vue.component('ResizeBarHorizontal', ResizeBarHorizontal)

        Vue.mixin({
            data(){
                return {
                    tooltip: {
                        show: false,
                        timeout: null
                    }
                }
            },
            methods: {
                showTooltip (event, title) {
                    let obj = event.currentTarget
                    clearTimeout(this.tooltip.timeout)
                    this.tooltip.timeout = setTimeout(() => {
                        this.tooltip = {show: true, title, obj}
                    }, 600)
                    obj.onmouseout = () => {
                        clearTimeout(this.tooltip.timeout)
                    }
                },
                hideTooltip () {
                    this.tooltip = {show: false, title: null, obj: null}
                }
            }
        })
    }
}