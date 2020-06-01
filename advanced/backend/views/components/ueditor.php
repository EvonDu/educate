<?php
\backend\assets\UEditorAsset::register($this);
?>

<component-template>
    <div :id="id" type="text/plain" style="width:100%;height:500px;"></div>
</component-template>
<script>
    Vue.component('ueditor', {
        model: { prop: 'value', event: 'change'},
        template: '{{component-template}}',
        props: {
            'value': {type:String, default: ""},
            'height': {type:Number, default: 300},
        },
        data:function(){
            return {
                "id":"ueditor_"+parseInt(Math.random()*9999),
            }
        },
        mounted:function(){
            var vue = this;
            var ue = UE.getEditor(this.id);
            ue.ready(function() {
                ue.setContent(vue.value);
            });
            ue.addListener('selectionchange',function(){
                var value = ue.getContent();
                vue.$emit('change', value);
            })
        }
    });
</script>