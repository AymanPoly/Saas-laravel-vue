<template>
  <div class="policy-generator">
    <div class="max-w-4xl mx-auto p-6">
      <h1 class="text-3xl font-bold mb-8 text-gray-800">AI Policy Generator</h1>
      
      <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="mb-6">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="policyType">
            Policy Type
          </label>
          <select
            v-model="selectedPolicyType"
            id="policyType"
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            <option value="">Select a policy type</option>
            <option value="remote_work">Remote Work Policy</option>
            <option value="harassment">Harassment Policy</option>
            <option value="vacation">Vacation Policy</option>
            <option value="data_security">Data Security Policy</option>
          </select>
        </div>

        <div class="mb-6">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="companyDetails">
            Company Details
          </label>
          <textarea
            v-model="companyDetails"
            id="companyDetails"
            rows="4"
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Enter company name, industry, and any specific requirements..."
          ></textarea>
        </div>

        <div class="mb-6">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="additionalRequirements">
            Additional Requirements
          </label>
          <textarea
            v-model="additionalRequirements"
            id="additionalRequirements"
            rows="3"
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Any specific requirements or considerations..."
          ></textarea>
        </div>

        <button
          @click="generatePolicy"
          :disabled="isGenerating"
          class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50"
        >
          {{ isGenerating ? 'Generating...' : 'Generate Policy' }}
        </button>
      </div>

      <div v-if="generatedPolicy" class="mt-8 bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Generated Policy</h2>
        <div class="prose max-w-none">
          <div v-html="generatedPolicy"></div>
        </div>
        <div class="mt-6 flex justify-end space-x-4">
          <button
            @click="downloadPolicy"
            class="bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
          >
            Download PDF
          </button>
          <button
            @click="savePolicy"
            class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            Save Policy
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PolicyGenerator',
  data() {
    return {
      selectedPolicyType: '',
      companyDetails: '',
      additionalRequirements: '',
      generatedPolicy: null,
      isGenerating: false
    }
  },
  methods: {
    async generatePolicy() {
      if (!this.selectedPolicyType) {
        alert('Please select a policy type')
        return
      }

      this.isGenerating = true
      try {
        const response = await axios.post('/api/generate-policy', {
          policyType: this.selectedPolicyType,
          companyDetails: this.companyDetails,
          additionalRequirements: this.additionalRequirements
        })
        this.generatedPolicy = response.data.policy
      } catch (error) {
        console.error('Error generating policy:', error)
        alert('Failed to generate policy. Please try again.')
      } finally {
        this.isGenerating = false
      }
    },
    async downloadPolicy() {
      if (!this.generatedPolicy) {
        alert('Please generate a policy first')
        return
      }

      try {
        const response = await axios.post('/api/download-policy-pdf', {
          policyType: this.selectedPolicyType,
          companyDetails: this.companyDetails,
          additionalRequirements: this.additionalRequirements
        }, {
          responseType: 'blob'
        })

        // Create a blob from the PDF Stream
        const file = new Blob([response.data], { type: 'application/pdf' })
        // Create a link element
        const fileURL = window.URL.createObjectURL(file)
        // Create a temporary link element
        const link = document.createElement('a')
        link.href = fileURL
        link.setAttribute('download', 'policy.pdf')
        // Append to the document
        document.body.appendChild(link)
        // Trigger the download
        link.click()
        // Clean up
        link.remove()
        window.URL.revokeObjectURL(fileURL)
      } catch (error) {
        console.error('Error downloading policy:', error)
        alert('Failed to download policy. Please try again.')
      }
    },
    savePolicy() {
      // Implement save functionality
    }
  }
}
</script>

<style scoped>
.policy-generator {
  min-height: 100vh;
  background-color: #f3f4f6;
}
</style> 