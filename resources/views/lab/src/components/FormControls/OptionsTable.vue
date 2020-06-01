<!-- Base usage -->
<!--
<options-table
    caption="Caption"
    captionClass="success-bg white-txt"
    v-bind:rows="options"></options-table>
-->
<template>
    <table class="full-width font-13" cellpadding="0" cellspacing="0" rules="cols" bordercolor="#CCC">
        <col class="w-32">
        <col>
        <col span="2" class="w-32">
        <thead class="h-32">
            <tr v-if="caption" v-bind:class="captionClass || 'primary-bg white-txt'">
                <th colspan="4">{{caption}}</th>
            </tr>
        </thead>
        <tbody v-on:input="changeData">
            <tr v-for="( value, index) of model" v-bind:key="index">
                <th title="Insert row"
                    class="white-bg black-txt hover-primary-bg"
                    v-on:click="insertRow(index + 1)">+</th>
                <td>
                    <input v-model="model[index]" class="full-width transparent border-none font-13">
                </td>
                <th title="Swap row"
                    class="bar-bg white-txt hover-primary-bg"
                    v-on:click="swapRow(index)">↑</th>
                <th title="Remove row"
                    class="white-bg black-txt hover-danger-bg"
                    v-on:click="removeRow(index)">✕</th>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "OptionsTable",
        data () {
            return {
                model: [],
                isChanged: false,
                timeout: null
            }
        },
        props: {
            caption: String,
            captionClass: String,
            rows: {
                type: Array,
                default: function () {
                    return []
                }
            }
        },
        created () {
            this.model = this.rows
        },
        methods: {
            changeData (isChanged = true) {
                this.isChanged = isChanged;
            },
            insertRow (index) {
                this.model.splice(index, 0, ['','']);
            },
            removeRow (index) {
                this.model.splice(index, 1);
                this.changeData()
            },
            swapRow (index) {
                let swap = index - 1;
                this.model[index] = this.model.splice(swap, 1, this.model[index])[0]
                this.changeData()
            },
        },
        watch: {
            model () {
                if (this.isChanged) {
                    clearTimeout(this.timeout)
                    this.timeout = setTimeout(() => {
                        console.log("Data changed")
                        this.changeData(false);
                    }, 1000)
                }
            }
        }
    }
</script>

<style scoped>
tr:nth-child(even) {
    background-color: #AAAAAA20;
}
tbody > tr > th {
    cursor: pointer;
}
td > input {
    height: 32px;
    padding: 5px 10px;
    text-align: inherit;
    box-sizing: border-box;
}
</style>