<template>
	<InertiaHead title="Verification Needed"/>

	<div class="flex flex-col space-y-8">
		<Breadcrumbs>
			<BreadcrumbsItem :href="route('panel.dashboard')">Dashboard</BreadcrumbsItem>
			<BreadcrumbsDivider/>
			<BreadcrumbsItem>Verification Needed</BreadcrumbsItem>
		</Breadcrumbs>

		<div class="rounded-md bg-blue-100 p-4 shadow">
			<div class="">
				<p class="text-sm leading-5 font-medium text-blue-800">
					You currently still need to verify your email address. Please check your email to verify this.
				</p>

			</div>
		</div>
		<div>
			<Button @click="resend" primary>Resend verification</Button>
		</div>
	</div>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'

import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import BreadcrumbsItem from '@/Components/BreadcrumbsItem.vue'
import BreadcrumbsDivider from '@/Components/BreadcrumbsDivider.vue'
import Badge from '@/Components/Badge.vue'
import Card from '@/Components/Card.vue'
import Button from '@/Components/Button.vue'
import Paginator from '@/Components/Paginator.vue'
import { useToast } from "vue-toastification";

export default {
	layout: AppLayout,
	components: {
		Breadcrumbs,
		BreadcrumbsItem,
		BreadcrumbsDivider,
		Badge,
		Card,
		Button,
		Paginator,
	},

	methods: {
		resend() {
			this.$inertia.post(this.route('verification.resend'), {}, {
				onFinish: () => {
					this.toast.success('Verification email has been sent!');
				}
			})
		}
	},

	setup() {
		const toast = useToast();
		return { toast }
	},
}
</script>
