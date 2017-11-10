<template>
  <div class="upload_picture" :style="{'line-height': height}" :class="{'radius': height != '250px'}">
    <Upload
      ref="uploader"
      v-show="status !== 'uploading'"
      :class="{'finished': status === 'finished'}"
      class="uploader"
      :style="{height}"
      :show-upload-list="false"
      :on-success="handleSuccess"
      :on-progress="handleProgress"
      :format="['jpg','jpeg','png', 'gif']"
      :max-size="2048"
      :on-format-error="handleFormatError"
      :on-exceeded-size="handleMaxSize"
      :on-error="handleError"
      :before-upload="handleBeforeUpload"
      name="image"
      type="select"
      :headers="{'X-Requested-With': 'XMLHttpRequest'}"
      :action="action">
      <div class="icon">
          <Icon :style="{'line-height': height}" type="camera" size="40"></Icon>
      </div>
    </Upload>
    <template v-if="status === 'uploading'">
      <Progress class="progress" :percent="percentage" hide-info></Progress>
    </template>
    <div class="upload_img" v-if="status === 'finished'">
      <img @error="imgLoadfailed" :src="picUrl">
      <div class="upload_img_option">
        <div class="icon_wrapper">
          <Icon title="替换" type="ios-camera-outline" @click.native="handleReplace"></Icon>
          <Icon title="移除" type="ios-trash-outline" @click.native="handleRemove"></Icon>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// todo 添加查看大图perview功能
import tHttp from '../utils/tHttp';
export default {
  name: 'uploadPicture',
  props: {
    height: {
      type: String,
      default: '250px'
    },
    url: String
  },
  watch: {
    'url' () {
      if (this.url) {
        this.status = 'finished';
        this.picUrl = this.url;
      }
    }
  },
  data () {
    return {
      status: 'normal',
      percentage: 1,
      picUrl: '',
      inputDom: null,
      action: tHttp.config.baseURL + 'ajax_upload_image'
    };
  },
  methods: {
    imgLoadfailed () {
      this.handleRemove();
    },
    handleBeforeUpload () {
      this.status = 'uploading';
      this.percentage = 1;
      this.picUrl = '';
    },
    handleSuccess (res) {
      this.picUrl = res.image_url;
      this.status = 'finished';
      this.$emit('on-success', res.image);
    },
    handleError (error, file) {
      if (error.status === 401) {
        this.$router.replace({name: 'login', query: {redirect: this.$route.name}});
      }
      this.handleRemove();
    },
    handleFormatError (file) {
      this.$Notice.warning({
        title: '文件格式不正确',
        desc: `文件${file.name}格式不正确，请上传 jpg, png, gif 格式的图片。`
      });
      this.handleRemove();
    },
    handleMaxSize (file) {
      this.$Notice.warning({
        title: '超出文件大小限制',
        desc: `文件 '${file.name}太大，不能超过 2M。`
      });
      this.handleRemove();
    },
    handleProgress (event, file) {
      this.percentage = event.percent;
    },
    handleRemove () {
      this.status = 'normal';
      this.picUrl = '';
      this.$emit('on-remove');
    },
    handleReplace () {
      if (this.inputDom === null) {
        this.inputDom = this.$refs['uploader'].$el.querySelector('.ivu-upload-input');
      }
      this.inputDom.click();
    }
  }
};
</script>

<style lang="less">
.upload_picture{
  overflow: hidden;
  background-color: hsla(0,0%,95%,.9);
  border: 2px dashed hsla(0,0%,40%,.2);
  position: relative;
  .icon .ivu-icon{
    color: #aaa!important;
    transition: color .2s ease;
  }
  &.radius{
    border-radius: 10px;
  }
  &:hover{
    .icon .ivu-icon{
      color: #444!important;
    }
    border-color: #999;
  }
  .uploader{
    text-align: center;
    transition: border-color .2s ease;
    >.ivu-upload{
      height: 100%;
      width: 100%;
      border: 0;
      cursor: pointer;
      background-color: transparent;
    }
    &.finished{
      display: none;
    }
  }
  .progress{
    padding: 0 75px;
  }
  .upload_img{
    height: 100%;
    >img{
      width: 100%;
      display: block;
    }
    .upload_img_option{
      position: absolute;
      bottom: -1px;
      right: -1px;
      background: rgba(0, 0, 0, .75);
      border-radius: 4px 0 0 0;
      >.icon_wrapper{
        width: 90px;
        height: 40px;
        position: relative;
        i:first-child, i:last-child{
          color: #fff;
          font-size: 32px;
          cursor: pointer;
          position: absolute;
          top: 0;
          width: 50%;
          text-align: center;
          line-height: 40px;
          &:hover{
            background-color: #000;
          }
        }
        i:first-child{
          left: 0;
        }
        i:last-child{
          right: 0;
        }
      }
    }
  }
}
</style>

