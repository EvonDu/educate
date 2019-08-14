Vue.component('upload', {
    model: { prop: 'value', event: 'change'},
    props:{
        'value':{ type: String, default: ""},
        'name':{ type: String, default: ""},
        'width':{ type: Number, default: 148},
        'height':{ type: Number, default: 148},
    },
    mounted:function(){
        var card = this.$refs.upload.$el.firstElementChild;
        card.style.width = this.width + "px";
        card.style.height = this.height + "px";
        card.style.lineHeight = (this.height-2) + "px";
        card.style.display = "flex";
        card.style.alignItems = "center";
        card.style.justifyContent = "center";
    },
    methods: {
        change:function(file, fileList){
            this.$emit('change', "assets/images/icon_zip.png");
        },
    },
    template: `<el-upload
            list-type="picture-card"
            ref="upload"
            :name="name"
            :auto-upload="false"
            :show-file-list="false"
            :on-change="change">
        <div v-if="value" style="width: 100%;height: 100%;margin: -1px;border: 1px solid #c0ccda;border-radius: 6px;overflow: hidden;position: relative;">
            <img :src="value" style="width: 100%;height: 100%;">
        </div>
        <i slot="default" class="el-icon-plus" v-else></i>
        <div slot="tip" class="el-upload__tip"><slot name="tip"></slot></div>
    </div>
    </el-upload>`
});