<template>
    <div class="tooltip"
         transition="tooltip-fade"
         v-bind:class="position.class"
         v-bind:style="position.offset">
        {{options.title}}
    </div>
</template>

<script>
    export default {
        name: "VTooltip",
        data () {
            return {
                obj: {}
            }
        },
        props: {
            options: Object
        },
        created (){
            this.obj = this.options.obj
            this.obj.onmouseout = () => {
                this.obj.onmouseout = null
                this.options.show = false
            }
        },
        computed: {
            position () {
                let screenFractions = {
                    width: window.innerWidth / 10,
                    height: window.innerHeight / 5
                }
                let position = {}
                let rect = this.obj.getBoundingClientRect()
                if (rect.x > (screenFractions.width * 9)) {
                    // To the Right of the object
                    position.class = 'before';
                    position.offset = `top: ${rect.y - (rect.height / 2)}px; left: ${rect.x}px`
                } else {
                    if (rect.x > screenFractions.width) {
                        if (rect.y > (screenFractions.height * 4)) {
                            // Over object
                            position.class = 'over';
                            position.offset = `bottom: ${rect.y}px; left: ${rect.x - (rect.width / 2)}px`
                        } else {
                            // Under the object
                            position.class = 'under';
                            position.offset = `top: ${rect.bottom - 10}px; left: ${Number(rect.x) + Number(rect.width / 2)}px`
                        }
                    } else {
                        // To the Left of the object
                        position.class = 'after';
                        position.offset = `top: ${Number(rect.y) + Number(rect.height / 2)}px; left: ${rect.right - 10}px`
                    }
                }
                return position;
            }
        }
    }
</script>

<style scoped>
.tooltip {
    z-index: 100;
    position: fixed;
    pointer-events: none;
}
.tooltip::before {
    content: "";
    position: absolute;
    border-width: 8px;
    border-style: solid;
    border-color: transparent;
}
.tooltip.over,
.tooltip.under,
.tooltip.over::before,
.tooltip.under::before {
    text-align: center;
    transform: translateX(-50%);
}
.tooltip.before,
.tooltip.after,
.tooltip.after::before,
.tooltip.before::before {
    text-align: left;
    transform: translateY(-50%);
}

.tooltip.over::before,
.tooltip.under::before {
    left: 50%;
}
.tooltip.after::before,
.tooltip.before::before {
    top: 50%;
}
.tooltip.over::before {
    top: 100%;
    border-top-color: var(--tooltip-bg, #222);
}
.tooltip.under::before {
    bottom: 100%;
    border-bottom-color: var(--tooltip-bg, #222);
}
.tooltip.before::before {
    left: 100%;
    border-right-color: var(--tooltip-bg, #222);
}
.tooltip.after::before {
    right: 100%;
    border-right-color: var(--tooltip-bg, #222);
}
</style>