import Diff from '../utils/Diff';
import mixinConfig from './mixinConfig';

let isSubmitJump = false;
let mainDiff = new Diff();
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
        action: '',
        singleDiffFields: [] // 单独diff的字段
      },
      singleDiffs: [] // 为单独字段diff的对象s
    };
  },
  beforeRouteLeave (to, from, next) {
    if (!mainDiff.oldObj || isSubmitJump) {
      next();
      return;
    }
    if (mainDiff.isDiff(this.formData)) {
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
      let submitFormData = mainDiff.diff(this.formData);
      this.singleDiffs.forEach(({name, diff}) => {
        if (diff.isSerializeDiff(this.formData[name])) {
          submitFormData[name] = this.formData[name];
        }
      });
      this.$http[this.isAdd() ? this.getConfig('addMethod') : this.getConfig('editMethod')](this.getConfig('action'), submitFormData).then(res => {
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
      mainDiff.save(formData);
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
          // 单独diff字段
          this.getConfig('singleDiffFields').forEach(item => {
            let diffTmp = new Diff();
            diffTmp.save(this.formData[item]);
            this.singleDiffs.push({
              name: item,
              diff: diffTmp
            });
          });
        });
        this.title = this.getConfig('editPrefix') + this.getConfig('title');
      } else {
        // 添加表单
        mainDiff.clear();
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
