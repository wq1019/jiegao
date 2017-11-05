import diff from '../utils/diff';
import mixinConfig from './mixinConfig';
let isSubmitJump = false;
export default {
  mixins: [mixinConfig],
  data () {
    return {
      title: '',
      errors: {},
      defaultConfig: {
        editPrefix: '编辑',
        addPrefix: '添加',
        editMethod: 'put',
        addMethod: 'post',
        query: {}, // 附加query参数
        title: '', // prefix + title = 最终标题
        action: ''
      }
    };
  },
  beforeRouteLeave (to, from, next) {
    if (!diff.oldObj || isSubmitJump) {
      next();
      return;
    }
    const diffObjStr = JSON.stringify(diff.diff(this.formData));
    if (diffObjStr !== '{}') {
      this.$Modal.confirm({
        title: '确认离开？',
        content: '<p>系统可能不会保存你的更改！</p>',
        onOk: () => {
          next();
        }
      });
    } else {
      next();
    }
  },
  methods: {
    confirm () {
      if (this.$refs.form) {
        this.$refs.form.validate((valid) => {
          if (!valid) {
            this.$Message.error('填写有误!');
            this.$emit('on-loaded');
          } else {
            this.submit();
          }
        });
      } else {
        this.submit();
      }
    },
    submit () {
      this.$http[this.isAdd() ? this.getConfig('addMethod') : this.getConfig('editMethod')](this.getConfig('action'), diff.diff(this.formData)).then(res => {
        this.$Message.success(`${this.title}成功`);
        isSubmitJump = true;
        this.$emit('on-success');
        this.$emit('on-loaded');
      }).catch(err => {
        try {
          this.errors = err.response.data.errors;
        } catch (e) {} finally {
          this.$emit('on-loaded');
        }
      });
    },
    isAdd () {
      return this.$route.meta.isAdd;
    },
    diffSave (formData) {
      diff.save(formData);
    },
    init () {
      if (!this.isAdd()) {
        // 编辑表单
        this.$http.get(this.getConfig('action'), {
          params: this.getConfig('query')
        }).then(res => {
          this.formData = res.data.data;
          this.diffSave(this.formData);
          this.$emit('on-data', this.formData);
        });
        this.title = this.getConfig('editPrefix') + this.getConfig('title');
      } else {
        // 添加表单
        diff.clear();
        this.title = this.getConfig('addPrefix') + this.getConfig('title');
      }
    }
  },
  created () {
    isSubmitJump = false;
    for (let key in this.formData) {
      this.$watch(`formData.${key}`, () => {
        if (this.errors[key]) {
          delete this.errors[key];
        }
      });
    }
    this.init();
  }
};
