<!-- Base Usage -->
<!--
<div ref="testBar" class="primary-bg" v-bind:style="{height: (bar.size) + 'px' }"></div>
<resize-bar-horizontal v-bind:element="testBar" v-bind:options="bar"/>
<script>
    export default {
        //
        data () {
            return {
                testBar: {},
                bar: {size: 200, min: 100, max: 400}
            }
        },
        mounted () {
            this.testBar = this.$refs.testBar
        }
    }
</script>
-->
<template>
    <div @mousedown.prevent="resize()" class="flex-center-center h-line silver-bg cursor-row-resize overflow-visible">
        <div class="light-bar border-light rounded-3 relative z-index-2">
            <div class="h-8 w-24"></div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ResizeBarHorizontal",
        props: {
            options: Object,
            element: {default: {}}
        },
        methods: {
            resize () {
                let offset = this.element.getBoundingClientRect().top;
                const min = this.options.min || 0
                const max = this.options.max || (window.innerHeight - offset)
                document.onmousemove = event => {
                    event.preventDefault()
                    let position = event.y - offset;
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