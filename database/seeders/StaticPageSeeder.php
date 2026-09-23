<?php

namespace Database\Seeders;

use App\Models\StaticPage;
use Illuminate\Database\Seeder;

class StaticPageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about',
                'content' => '<p>Welcome to our store. We are dedicated to providing the best products and services to our customers. With years of experience in the industry, we strive to deliver quality and value.</p><p>Our mission is to make online shopping easy, affordable, and enjoyable for everyone.</p>',
                'meta_title' => 'About Us',
                'meta_description' => 'Learn more about our store, our mission, and our commitment to quality.',
                'is_active' => true,
                'display_order' => 1,
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact',
                'content' => '<p>We would love to hear from you. Please reach out to us using the contact information below.</p><p><strong>Email:</strong> info@example.com</p><p><strong>Phone:</strong> +0123 456 789</p><p><strong>Address:</strong> 123 Main Street, City, Country</p>',
                'meta_title' => 'Contact Us',
                'meta_description' => 'Get in touch with our team. We are here to help.',
                'is_active' => true,
                'display_order' => 2,
            ],
            [
                'title' => 'FAQs',
                'slug' => 'faq',
                'content' => '<h3>Frequently Asked Questions</h3><p><strong>Q: How do I place an order?</strong><br>A: Browse our products, add them to your cart, and proceed to checkout.</p><p><strong>Q: What payment methods do you accept?</strong><br>A: We accept cash on delivery, bKash, Nagad, and bank transfer.</p><p><strong>Q: How can I track my order?</strong><br>A: Once your order is shipped, you will receive a tracking number via email.</p>',
                'meta_title' => 'FAQs',
                'meta_description' => 'Find answers to frequently asked questions about our products and services.',
                'is_active' => true,
                'display_order' => 3,
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms',
                'content' => '<p>These terms and conditions outline the rules and regulations for the use of our website. By accessing this website, we assume you accept these terms and conditions.</p><p>We reserve the right to change these terms at any time without notice.</p>',
                'meta_title' => 'Terms & Conditions',
                'meta_description' => 'Read our terms and conditions for using our website and services.',
                'is_active' => true,
                'display_order' => 4,
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy',
                'content' => '<p>Your privacy is important to us. This privacy policy explains how we collect, use, and protect your personal information when you use our website.</p><p>We do not sell or share your personal information with third parties without your consent.</p>',
                'meta_title' => 'Privacy Policy',
                'meta_description' => 'Learn how we collect, use, and protect your personal information.',
                'is_active' => true,
                'display_order' => 5,
            ],
            [
                'title' => 'Return Policy',
                'slug' => 'returns',
                'content' => '<p>We offer a 30-day return policy for all unused items in original packaging. If you are not satisfied with your purchase, please contact our support team within 30 days of delivery to initiate a return.</p><p>Refunds will be processed within 7-10 business days after we receive the returned item.</p>',
                'meta_title' => 'Return Policy',
                'meta_description' => 'Learn about our 30-day return policy and how to initiate a return.',
                'is_active' => true,
                'display_order' => 6,
            ],
            [
                'title' => 'Shipping Policy',
                'slug' => 'shipping',
                'content' => '<p>We offer free standard shipping on all orders over $50. Orders are typically processed within 1-2 business days. Delivery times vary by location but generally range from 3-7 business days.</p><p>Express shipping is available at an additional cost.</p>',
                'meta_title' => 'Shipping Policy',
                'meta_description' => 'Information about our shipping options, rates, and delivery times.',
                'is_active' => true,
                'display_order' => 7,
            ],
        ];

        foreach ($pages as $page) {
            StaticPage::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}
