document.addEventListener('DOMContentLoaded', function () {
    const categories = document.querySelectorAll('#category-list li');
    const serviceTitle = document.getElementById('service-title');
    const serviceText = document.getElementById('service-text');

    const descriptions = {
        "Wash & Fold": "Our wash & fold service ensures your clothes are thoroughly cleaned, dried, and neatly folded. We use high-quality detergents and softeners to maintain fabric freshness and longevity. Perfect for everyday laundry needs, this service saves you time while keeping your clothes fresh and ready to wear",
        "Dry Cleaning": "Delicate fabrics like suits, dresses, and coats require special care. Our dry cleaning service uses advanced cleaning techniques and solvent-based solutions to remove dirt and stains without damaging the material. Ideal for formal wear and delicate garments, we ensure your clothes remain spotless, crisp, and well-maintained.",
        "Ironing & Pressing": "Keep your clothes wrinkle-free and professionally pressed with our ironing service. We use high-quality steam and dry ironing techniques to give your garments a polished, crisp look. Whether it's office wear, casual outfits, or special attire, our ironing service ensures you always look sharp and well-groomed.",
        "Sewing & Alterations": "From minor repairs to custom alterations, our sewing service ensures your clothes fit perfectly. We fix torn seams, adjust hems, resize garments, and even customize designs. Whether you need a simple button replacement or a complete fit adjustment, our skilled tailors provide high-quality craftsmanship to keep your outfits in top shape.",
        "Commercial Laundry": "Need laundry service for large loads? Our bulk laundry service is perfect for hotels, hospitals, restaurants, and businesses. We handle high-volume laundry efficiently, using industrial-grade machines and detergents to ensure deep cleaning. Whether it’s uniforms, linens, or bedding, we guarantee fast and high-quality service.",
        "Pickup & Delivery": "Enjoy hassle-free laundry with our pickup and delivery service. We collect your clothes from your doorstep, clean them with care, and deliver them back fresh and neatly packed. Perfect for busy individuals and businesses, this service saves time and ensures your laundry is handled with convenience and efficiency."
    };

    categories.forEach(category => {
        category.addEventListener('click', function () {
            categories.forEach(el => el.classList.remove("active"));

            this.classList.add("active");

            const selectedCategory = this.textContent.trim();
            serviceTitle.textContent = selectedCategory;
            serviceText.textContent = descriptions[selectedCategory] || "Description not available.";
        });
    });

    // Remove active class when clicking outside the list
    document.addEventListener("click", function (event) {
        if (!event.target.closest(".categories")) {
            categories.forEach(el => el.classList.remove("active"));
        }
    });
});
