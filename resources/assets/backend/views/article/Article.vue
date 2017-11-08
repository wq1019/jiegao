<template>
  <div class="article">
    <h1 class="title">{{title}}</h1>
    <TitleWithContent :titleError="errors.title" :contentError="errors.content" :title.sync="formData.title" :attachments="formData.attachments.data" :attachment_ids.sync="formData.attachment_ids" :content.sync="formData.content"></TitleWithContent>
    <div class="option">
      <div class="left">
        <CategorySelectPanel :cateError="errors.category_id" :cid.sync="formData.category_id" class="type_panel"></CategorySelectPanel>
        <Panel title="标签" full size="small" class="cover">
          <TagAutoComplete :oldTags="formData.tags.data" @tag_ids="ids => formData.tag_ids = ids" />
        </Panel>
        <Panel title="封面" full size="small" class="cover">
          <UploadPicture :url="formData.cover_url" @on-remove="() => formData.cover = null" @on-success="cover => formData.cover = cover"></UploadPicture>
        </Panel>
        <Panel title="自定义字段" full size="small" close class="cover">
          <Form class="fields" :model="formData" label-position="top">
            <Row :gutter="16" v-for="(item, index) in formData.fields" :key="index" class="field_item">
              <Col span="11">
                <Form-item label="字段名">
                  <Input v-model="item.key" placeholder="请输入字段名"></Input>
                </Form-item>
              </Col>
              <Col span="11">
                <Form-item label="字段值">
                  <Input v-model="item.value" placeholder="请输入字段值"></Input>
                </Form-item>
              </Col>
              <Col span="2">
                <Button @click="delField(index)" type="error" class="del_btn" size="small" >删除</Button>
              </Col>
            </Row>
            <Button type="primary" icon="plus-round" @click="addField">添加字段</Button>
          </Form>
        </Panel>
      </div>
      <Panel title="发布" full size="small" width="300px">
        <Form ref="form" :rules="rules" :model="formData" label-position="top">
          <Form-item label="发布时间" :error="errors.published_at">
            <Date-picker type="datetime" placeholder="选择发布时间" v-model="formData.published_at"></Date-picker>
          </Form-item>
          <Form-item label="正文模板" prop="template" :error="errors.template">
            <Select v-model="formData.template" placeholder="请选择正文模板">
              <Option v-for="item in contentTemplates" :key="item.file_name" :value="item.file_name">{{item.title}}</Option>
            </Select>
          </Form-item>
          <Row>
            <Col span="12">
              <Form-item label="排序" :error="errors.order">
                <Input-number :min="0" v-model="formData.order"></Input-number>
              </Form-item>
            </Col>
            <Col span="12">
            <Form-item label="浏览次数" :error="errors.views_count">
              <Input-number :min="0" v-model="formData.views_count"></Input-number>
            </Form-item>
            </Col>
          </Row>
          <Form-item label="置顶开关" :error="errors.top">
            <i-switch v-model="formData.top" size="large">
              <span slot="open">ON</span>
              <span slot="close">OFF</span>
            </i-switch>
          </Form-item>
          <ButtonGroup>
            <Button :loading="loading" @click="submitArticle('publish')" type="success">{{isAdd() ? '发布' : '提交修改'}}</Button>
            <Button :loading="loading" @click="submitArticle('draft')" type="primary">保存为草稿</Button>
            <Button @click="$router.back()">取消</Button>
          </ButtonGroup>
        </Form>
      </Panel>
    </div>
  </div>
</template>
<script>
import TitleWithContent from '../../components/TitleWithContent.vue';
import TagAutoComplete from '../../components/TagAutoComplete.vue';
import Panel from '../../components/Panel.vue';
import UploadPicture from '../../components/UploadPicture.vue';
import fromMixin from '../../mixins/form';
import CategorySelectPanel from '../../components/CategorySelectPanel.vue';
export default {
  mixins: [fromMixin],
  components: { TitleWithContent, Panel, UploadPicture, CategorySelectPanel, TagAutoComplete },
  computed: {
    rules () {
      return {
        template: [
          { required: true, type: 'string', message: '请选择正文模板', trigger: 'change' }
        ]
      };
    },
    mixinConfig () {
      return {
        title: '文章',
        action: this.isAdd() ? 'posts' : `posts/${this.$route.params.id}`,
        addPrefix: '撰写新',
        query: {
          include: 'post_content,attachments,tags'
        },
        singleDiffFields: ['fields']
      };
    }
  },
  methods: {
    submitArticle (status) {
      this.loading = true;
      this.formData.status = status;
      this.confirm();
    },
    delField (index) {
      const self = this;
      this.$Modal.confirm({
        title: '确认删除该字段',
        content: '确认删除？',
        onOk: () => {
          self.formData.fields.splice(index, 1);
          this.$forceUpdate();
        }
      });
    },
    addField () {
      if (!this.formData.fields) {
        this.formData.fields = [];
      }
      this.formData.fields.push({
        key: '',
        value: ''
      });
      this.$forceUpdate();
    }
  },
  data () {
    return {
      formData: {
        'title': null,
        'slug': null,
        'excerpt': null,
        'content': null,
        'cover': null,
        'status': null,
        'type': null,
        'views_count': 0,
        'top': false,
        'order': 0,
        'template': null,
        'category_id': null,
        'published_at': null,
        'attachments': [],
        'attachment_ids': [],
        'tags': [],
        'tag_ids': [],
        'fields': []
      },
      contentTemplates: [],
      loading: false
    };
  },
  mounted () {
    this.formData.published_at = new Date();
    this.$on('on-data', formData => {
      this.formData.content = formData.post_content.data.content;
      this.formData.attachment_ids = formData.attachments.data.map(item => {
        return item.id;
      });
      this.diffSave(this.formData);
    });
    this.$on('on-success', formData => {
      this.$router.push({ name: 'articleList' });
    });
    this.$on('on-loaded', () => {
      this.loading = false;
    });
    this.$http.get('templates', {
      params: {
        template_type: 'content'
      }
    }).then(res => {
      this.contentTemplates = res.data.content;
      if (this.isAdd()) {
        if (this.contentTemplates[0]) {
          this.formData.template = this.contentTemplates[0].file_name;
        }
      }
    });
  }
};
</script>

<style lang="less" scoped>
.article {
  .title {
    font-weight: 400;
    line-height: 32px;
    font-size: 20px;
    margin-bottom: 25px;
  }
  >main {
    background-color: #fff;
    padding: 40px;
    margin-bottom: 30px;
    .title_input_wrapper {
      padding-bottom: 20px;
    }
  }
  .option {
    display: flex;
    flex-direction: row;
    >.left {
      flex-grow: 1;
      margin-right: 30px;
      .type_panel,
      .cover {
        height: auto;
        max-width: 650px;
        margin-bottom: 30px;
        .fields{
          .del_btn{
            margin-top: 27px;
          }
        }
      }
    }
  }
}
</style>
