<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

export default {
  components: { DatePicker },
  props: ['name', 'value', 'className', 'format'],
  data() {
    return {
      date: this.value,
    };
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
        :use12h="true"
        :class="className"
        :valueType="format || 'YYYY-MM-DD HH:mm:ss'"></date-picker>

    <input type="hidden" :name="name" :value="date">
  </div>
</template>