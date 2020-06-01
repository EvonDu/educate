<component-template>
    <el-input :value="temp" :disabled="disabled" @input="change" @blur="blur"></el-input>
</component-template>

<script>
    Vue.component('input-price', {
        template: '{{component-template}}',
        model: {
            prop: 'value', event: 'change'
        },
        props:{
            'value':{'default': null},
            'disabled':{'default':false}
        },
        watch:{
            value:function(val){
                this.temp = val/100;
            }
        },
        data:function(){
            return {
                temp:0
            }
        },
        created:function(){
            this.temp = this.value/100;
        },
        methods: {
            change:function (value) {
                var v = value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3');
                this.temp = v;
            },
            blur:function () {
                this.$emit('change', this.temp * 100);
            }
        }
    });
</script>