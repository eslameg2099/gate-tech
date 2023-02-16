<template>
  <div>
    <div class="invoice-container">
      <h4 class="text-center" v-if="type === 'credit'">{{ $t('transactions.catch_receipt') }}</h4>
      <h4 class="text-center" v-if="type === 'debit'">{{ $t('transactions.debit_receipt') }}</h4>
      <div class="d-flex justify-content-between align-items-center form-group">
        <p>{{ $t('transactions.attributes.id') }}: .....</p>
        <div class="row align-items-center" style="width: 50%">
          <div class="col-3">{{ $t('transactions.attributes.date') }}:</div>
          <div class="col-9">
            <datepicker name="date"
                        class-name=""
                        format="YYYY-MM-DD"
                        v-model="values.date"></datepicker>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-between align-items-center form-group">
        <div class="row align-items-center" style="width: 50%">
          <div class="col-3">{{ $t('buildings.singular') }}:</div>
          <div class="col-9">
            <select v-model="values.building_id" class="form-control input-sm">
              <option value="" hidden>{{ $t('buildings.select') }}</option>
              <option v-for="building in buildings" :value="building.id">
                {{ building.name }}
              </option>
            </select>
          </div>
        </div>
        <div class="row align-items-center" style="width: 50%">
          <div class="col-3">{{ $t('apartments.singular') }}:</div>
          <div class="col-9">
            <select v-model="values.apartment_id" class="form-control input-sm">
              <option value="" hidden>{{ $t('apartments.select') }}</option>
              <option v-for="apartment in apartments" :value="apartment.id">
                {{ apartment.name }}
              </option>
            </select>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-between align-items-center form-group" v-if="selectedApartment && selectedApartment.rent">
        <p>{{ $t('rents.attributes.user_id') }}: {{ selectedApartment.rent.tenant.name }}</p>
        <p v-if="selectedApartment.rent.last_installment">
          {{ $t('installments.attributes.status') }}: <bdi>{{ selectedApartment.rent.last_installment.message }}</bdi>
        </p>
      </div>
      <div class="d-flex justify-content-between align-items-center form-group">
        <div class="row align-items-center" style="width: 50%">
          <div class="col-4">
            <span v-if="type === 'credit'">{{ $t('transactions.attributes.credit_to') }}</span>
            <span v-if="type === 'debit'">{{ $t('transactions.attributes.debit_from') }}</span>
            :</div>
          <div class="col-8">
            <select v-model="values.wallet_id" class="form-control input-sm" required>
              <option value="" hidden>{{ $t('transactions.select_wallet') }}</option>
              <option v-for="wallet in wallets" :value="wallet.id">
                {{ wallet.text }}
              </option>
            </select>
          </div>
        </div>
        <div class="row align-items-center" style="width: 50%">

        </div>
      </div>
      <div class="d-flex justify-content-between align-items-center form-group">
        <div class="row align-items-center" style="width: 50%">
          <div class="col-4">{{ $t('transactions.attributes.amount') }}:</div>
          <div class="col-8">
            <input type="text"
                   required
                   data-inputmask="'alias': 'currency'"
                   autocomplete="off"
                   class="form-control"
                   v-model="values.amount"
                   @blur="getAmountString"
                   name="amount"
                   id="amount">
          </div>
        </div>
        <div class="row align-items-center" style="width: 50%">
            {{ amount_string }}
        </div>
      </div>
      <div class="d-flex justify-content-between form-group">
        <div class="row" style="width: 50%">
          <div class="col-4" v-if="type === 'credit'">{{ $t('transactions.attributes.payment_method') }}:</div>
          <div class="col-4" v-else>{{ $t('transactions.attributes.debit_method') }}:</div>
          <div class="col-8">
            <select v-model="values.payment_method" class="form-control input-sm" required>
              <option value="" hidden>{{ $t('transactions.select_payment_method') }}</option>
              <option v-for="payment_method in payment_methods" :value="payment_method.code">
                {{ payment_method.name }}
              </option>
            </select>
          </div>
          <div v-if="['cash_checks', 'bank_transfer'].includes(values.payment_method)" class="col-4">{{ $t('transactions.attributes.check_number') }}:</div>
          <div v-if="['cash_checks', 'bank_transfer'].includes(values.payment_method)" class="col-8">
            <input type="text"
                   required
                   class="form-control"
                   v-model="values.check_number"
                   name="reason"
                   id="check_number">
          </div>
        </div>
        <div class="row align-items-center" style="width: 50%">
          <file-uploader
              v-if="['cash_checks', 'bank_transfer'].includes(values.payment_method)"
              :unlimited="false"
              name="check_image"
              v-model="values.check_image"
              :tokens="[]"
              :label="$t('transactions.attributes.check_image')"
              notes="Supported types: jpeg, png,jpg,gif"
              :display-validation-messages="true"
          ></file-uploader>
        </div>
      </div>
      <div class="d-flex justify-content-between align-items-center form-group">
        <div class="row align-items-center" style="width: 50%">
          <div class="col-4">{{ $t('transactions.attributes.reason') }}:</div>
          <div class="col-8">
            <input type="text"
                   required
                   class="form-control"
                   v-model="values.reason"
                   name="reason"
                   id="reason">
          </div>
        </div>
        <div v-if="type === 'debit'" class="row align-items-center" style="width: 50%">
          <div class="col-4">{{ $t('transactions.attributes.service_id') }}:</div>
          <div class="col-8">
            <select v-model="values.service_id" class="form-control input-sm" required>
              <option value="" hidden>{{ $t('services.select') }}</option>
              <option v-for="service in services" :value="service.id">
                {{ service.text }}
              </option>
            </select>
          </div>
        </div>
      </div>
      <input type="hidden" name="wallet_id" :value="values.wallet_id">
      <input type="hidden" name="building_id" :value="values.building_id">
      <input type="hidden" name="apartment_id" :value="values.apartment_id">
      <input type="hidden" name="amount" :value="values.amount">
      <input type="hidden" name="check_image" :value="values.check_image">
      <input type="hidden" name="payment_method" :value="values.payment_method">
      <input type="hidden" name="date" :value="values.date">
      <input type="hidden" name="reason" :value="values.reason">
      <input type="hidden" name="type" :value="values.type">
      <input type="hidden" name="check_number" :value="values.check_number">
      <input type="hidden" name="service_id" :value="values.service_id">
      <slot></slot>
    </div>
  </div>
</template>
<style scoped>
.invoice-container {
  border: 1px solid #eee;
  padding: 10px;
}
</style>
<script>
import Autocomplete from 'vuejs-auto-complete'

export default {
  components: {
    Autocomplete
  },
  props: ['type'],
  data() {
    return {
      buildings: [],
      apartments: [],
      payment_methods: [
        {
          code: 'cash_money',
          name: this.$t('transactions.payment_methods.cash_money'),
        },
        {
          code: 'cash_checks',
          name: this.$t('transactions.payment_methods.cash_checks'),
        },
        {
          code: 'bank_transfer',
          name: this.$t('transactions.payment_methods.bank_transfer'),
        },
        {
          code: 'visa',
          name: this.$t('transactions.payment_methods.visa'),
        },
      ],
      wallets: [],
      services: [],
        values: {
          wallet_id: null,
          reason: null,
          type: this.type,
          building_id: null,
          apartment_id: null,
          amount: null,
          check_image: null,
          check_number: null,
          payment_method: null,
          service_id: null,
          date: window.moment().format('YYYY-MM-DD'),
        },
      amount_string: null,
      selectedApartment: null,
    }
  },
  async created() {
    if (this.type === 'debit') {
      this.values.payment_method = 'cash_money'
      let servicesResponse = await axios.get('/api/select/services');
      this.services = servicesResponse.data.data
    }
    let response = await axios.get('/api/buildings');
    this.buildings = response.data.data

    let walletResponse = await axios.get('/api/select/wallets');
    this.wallets = walletResponse.data.data
  },

  watch: {
    "values.building_id": {
      async handler(id) {
        if (id) {
          let apartmentResponse = await axios.get('/api/apartments?building_id=' + id);
          this.apartments = apartmentResponse.data.data

          let walletsResponse = await axios.get('/api/select/wallets?building_id=' + id);
          this.wallets = walletsResponse.data.data
        } else {
          let walletsResponse = await axios.get('/api/wallets');
          this.wallets = walletsResponse.data.data
          this.apartments = [];
        }
      }
    },
    "values.apartment_id": {
      async handler(id) {
        if (id) {
          let response = await axios.get('/api/apartments/' + id);
          this.selectedApartment = response.data.data
        } else {
          this.selectedApartment = null;
        }
      }
    }
  },

  methods: {
    async getAmountString() {
      this.amount_string = '';
      if (this.values.amount) {
        let response = await axios.get('/number-to-string/' + this.values.amount);
        this.amount_string = response.data.string
      }
    }
  }
}
</script>