<template>
  <div class="column">
    <Panel :title="title">
      <Form ref="form" :rules="rules" :model="formData" :label-width="100">
        <Form-item label="分类名" :error="errors.cate_name" prop="cate_name">
          <Input v-model="formData.cate_name" placeholder="请设置分类名"></Input>
        </Form-item>
        <Form-item label="栏目描述" :error="errors.description">
          <Input v-model="formData.description" type="textarea" :rows="4" placeholder="请输入栏目描述"></Input>
        </Form-item>
        <Form-item label="父级栏目" :error="errors.parent_id">
          <Select v-model="formData.parent_id">
            <Option :value="0" :key="0">作为父级栏目</Option>
            <Option v-for="item in categories" :value="item.id" :key="item.id">{{ item.cate_name }}</Option>
          </Select>
        </Form-item>
        <Form-item label="排序" :error="errors.order">
          <InputNumber :min="0" v-model="formData.order"></InputNumber>
        </Form-item>
        <Form-item label="栏目图片" :error="errors.image">
          <UploadPicture @on-remove="() => formData.image = null" @on-success="image => formData.image = image" :url="formData.image_url" height="180px" class="upload_picture" />
        </Form-item>
        <Form-item label="设为导航" :error="errors.is_nav">
          <i-switch v-model="formData.is_nav" size="large">
            <span slot="open">导航</span>
            <span slot="close">普通</span>
          </i-switch>
        </Form-item>
        <Form-item label="栏目类型" :error="errors.type">
          <Select v-model="formData.type">
              <Option value="post" :key="0">列表栏目</Option>
              <Option value="page" :key="1">单网页</Option>
              <Option value="link" :key="2">外部链接</Option>
          </Select>
        </Form-item>
        <Form-item v-if="formData.type === 'post'" label="列表模版" prop="list_template" :error="errors.list_template">
          <Select v-model="formData.list_template" key="list">
            <Option v-for="item in templates.list" :value="item.file_name" :key="item.file_name">{{item.title}}({{item.file_name}})</Option>
          </Select>
        </Form-item>
        <Form-item v-if="formData.type === 'post'" label="正文模版" prop="content_template" :error="errors.content_template">
          <Select v-model="formData.content_template" key="content">
              <Option v-for="item in templates.content" :value="item.file_name" :key="item.file_name">{{item.title}}({{item.file_name}})</Option>
          </Select>
        </Form-item>
        <Form-item v-if="formData.type === 'page'" label="单页模版" prop="page_templates" :error="errors.page_templates">
          <Select v-model="formData.page_template" key="page">
              <Option v-for="item in templates.page" :value="item.file_name" :key="item.file_name">{{item.title}}({{item.file_name}})</Option>
          </Select>
          <Button style="margin-left: 10px;" v-if="$route.params.id" @click="$router.push({name: 'page', params: { id: $route.params.id }})" icon="edit" type="primary">编辑单页</Button>
        </Form-item>
        <Form-item v-if="formData.type === 'link'" label="外部链接" prop="url" :error="errors.url">
          <Input v-model="formData.url" placeholder="请设置外部链接"></Input>
        </Form-item>
        <Form-item v-if="formData.type === 'link'" label="新标签页打开" :error="errors.is_target_blank">
          <i-switch v-model="formData.is_target_blank">
            <span slot="open">是</span>
            <span slot="close">否</span>
          </i-switch>
        </Form-item>
        <FormButtomGroup />
      </Form>
    </Panel>
  </div>
</template>

<script>
import Panel from '../../components/Panel.vue';
import fromMixin from '../../mixins/form';
import FormButtomGroup from '../../components/FormButtonGroup.vue';
import UploadPicture from '../../components/UploadPicture.vue';
export default {
  components: { Panel, FormButtomGroup, UploadPicture },
  mixins: [ fromMixin ],
  computed: {
    rules () {
      return {
        cate_name: [
          { required: true, type: 'string', message: '请填写分类名称', trigger: 'blur' }
        ],
        page_template: [
          { required: this.formData.type === 'page', type: 'string', message: '请选择单页模版', trigger: 'change' }
        ],
        content_template: [
          { required: this.formData.type === 'post', type: 'string', message: '请选择正文模版', trigger: 'change' }
        ],
        list_template: [
          { required: this.formData.type === 'post', type: 'string', message: '请选择列表模版', trigger: 'change' }
        ],
        url: [
          { required: this.formData.type === 'link', type: 'string', message: '请填写URL', trigger: 'blur' }
        ]
      };
    },
    mixinConfig () {
      return {
        title: '栏目',
        action: this.isAdd() ? 'categories' : `categories/${this.$route.params.id}`,
      };
    }
  },
  watch: {
    'formData.type' (newVal) {
      this.changeType(newVal);
    }
  },
  methods: {
    changeType (type) {
      if (type === 'page') {
        // 单网页
        this.formData.page_template = this.templates.page[0].file_name;
        this.formData.content_template = null;
        this.formData.list_template = null;
      } else if (type === 'post') {
        // 列表
        this.formData.content_template = this.templates.content[0].file_name;
        this.formData.list_template = this.templates.list[0].file_name;
        this.formData.page_template = null;
      } else {
        // 外部链接
        this.formData.page_template = null;
        this.formData.content_template = null;
        this.formData.list_template = null;
      }
    }
  },
  mounted () {
    this.$http.get('templates').then(res => {
      this.templates = res.data;
      if (this.formData.type) {
        if (this.isAdd()) {
          this.changeType(this.formData.type);
        }
      }
    });
    this.$http.get('categories').then(res => {
      this.categories = res.data.data;
    });
    this.$on('on-success', () => {
      this.$router.push({name: 'columnList'});
    });
  },
  data () {
    return {
      templates: {},
      categories: [],
      formData: {
        'type': 'post',
        'image': null,
        'parent_id': 0,
        'cate_name': null,
        'description': null,
        'url': null,
        'is_target_blank': true,
        'is_nav': true,
        'order': 0,
        'page_template': null,
        'list_template': null,
        'content_template': null
      }
    };
  }
};
</script>

<style lang="less" scoped>
.column{
  .upload_picture{
    width: 180px;
    margin-top: 10px;
  }
  .ivu-select{
    width: 200px;
  }
}
</style>
