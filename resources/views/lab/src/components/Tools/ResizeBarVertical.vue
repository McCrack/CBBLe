<!-- Base Usage -->
<!--
<div ref="testBar" class="primary-bg" v-bind:style="{width: (bar.size) + 'px' }"></div>
<resize-bar-vertical v-bind:element="testBar" v-bind:options="bar"/>
<script>
    export default {
        //
        data () {
            return {
                testBar: {},
                bar: {size: 200, min: 300, max: (window.innerWidth / 2)}
            }
        },
        mounted () {
            this.testBar = this.$refs.testBar
        }
    }
</script>
-->
<template>
    <div @mousedown.prevent="resize()" class="flex-center-center v-line silver-bg cursor-col-resize overflow-visible">
        <div class="light-bar border-light rounded-3 relative z-index-2">
            <div class="w-8 h-24"></div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ResizeBarVertical",
        props: {
            options: Object,
            element: {default: {}}
        },
        methods: {
            resize () {
                let offset = this.element.getBoundingClientRect().left;
                const min = this.options.min || 0
                const max = this.options.max || (window.innerWidth - offset)
                document.onmousemove = event => {
                    event.preventDefault()
                    let position = event.x - offset
                    if ((position > min) && (position < max)) {
                        this.options.size = position
                    }
                }
                document.onmouseup = () => {
                    document.onmouseup = document.onmousemove = null
                }
            }
        }
    }
</script>

<style scoped>

</style>