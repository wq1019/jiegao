<template>
  <div class="panel" :style="{'width': width}" :class="size">
    <header @click="closed = !closed">
      <h1>{{title}}</h1>
      <Icon :class="{'close': closed}" size="16" color="#999" class="icon" type="chevron-down"></Icon>
    </header>

    <transition name="slide-fade">
      <main v-show="!closed" class="body_wrapper">
        <div class="body" :class="{'full': full}">
          <slot></slot>
        </div>
      </main>
    </transition>

  </div>
</template>

<script>
export default{
  name: 'panel',
  props: {
    title: {
      type: String,
      required: true
    },
    width: {
      type: String,
      default: 'auto'
    },
    size: {
      type: String,
      default: 'large'
    },
    full: {
      type: Boolean,
      default: false
    },
    close: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {
      closed: this.close
    };
  }
};
</script>
<style scoped lang="less">
  .slide-fade-enter-active {
    transition: all .3s ease;
  }
  .slide-fade-leave-active {
    transition: all .3s ease;
  }
  .slide-fade-enter, .slide-fade-leave-to
  /* .slide-fade-leave-active for below version 2.1.8 */ {
    transform: translateX(10px);
    opacity: 0;
  }
  .panel{
    margin-bottom: 20px;
    border-radius: 4px;
    box-shadow: 0 1px 1px rgba(0,0,0,.05);
    height: 100%;
    background-color: #fff;
    &.small{
      header{
        position: relative;
        cursor: pointer;
        &:active{
          background-color: #f9f9f9;
        }
        h1{
          height: 45px;
          font-size: 16px;
          line-height: 45px;
          font-weight: normal;
          padding: 0;
          padding-left: 15px;
        }
        .icon{
          top: 14px;
          right: 14px;
        }
      } 
    }
    header{
      position: relative;
      border-bottom: 1px solid #eee;
      .icon{
        position:  absolute;
        top: 24px;
        right: 19px;
        transition: transform .3s;
        &.close{
          transform: rotate(180deg);
        }
      }
      >h1{
        padding: 20px;
        font-weight: 700;
        font-size: 18px;
      }
      >.header_right{
        position: absolute;
        top: 50%;
        right: 20px;
        transform: translate(0,-50%);
      }
    }
    .body_wrapper{
      border: 1px solid transparent;
      .body{
        width: 500px;
        padding: 40px 15px;
        float: inherit;
        margin: 0 auto;
        &.full{
          width: 100%;
          padding: 20px 15px;
        }
      }
    }
  }
</style>
