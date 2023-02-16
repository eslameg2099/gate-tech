<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

export default {
  components: { DatePicker },
  props: ['fromName', 'toName', 'from', 'to', 'value', 'className', 'format'],
  data() {
    return {
      date: [],
    };
  },
  created() {
    if (this.from && this.to) {
      this.date = [this.from, this.to];
    }
    if (Array.isArray(this.value) && this.value.length === 2) {
      this.date = this.value
    }
  },
  watch: {
    date(val) {
      this.$emit('input', val);
    }
  }
};
</script>
<style>
.mx-datepicker {
  width: 100%;
}
.is-invalid input,.is-invalid input:hover,.is-invalid input:active,.is-invalid input:focus {
  border-color: #dc3545;
}
.is-invalid svg,.is-invalid svg:hover,.is-invalid svg:focus,.is-invalid svg:active {
  fill: #dc3545;
}
.mx-table-date .today {
  color: #2a90e9 !important;
  font-weight: bold;
}
</style>
<template>
  <div>
    <date-picker
        v-model="date"
        range
        :use12h="true"
        :class="className"
        :valueType="format || 'YYYY-MM-DD HH:mm:ss'"></date-picker>

    <input type="hidden" v-if="date.length === 2" :name="fromName" :value="date[0]">
    <input type="hidden" v-if="date.length === 2" :name="toName" :value="date[1]">
  </div>
</template>