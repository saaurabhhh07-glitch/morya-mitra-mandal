import { createClient } from "@supabase/supabase-js";

const supabase = createClient(
  process.env.SUPABASE_URL,
  process.env.SUPABASE_SERVICE_ROLE_KEY
);

export default async function handler(req, res) {
  // Only POST requests are allowed
  if (req.method !== "POST") {
    return res.status(405).json({
      success: false,
      error: "Method not allowed"
    });
  }

  try {
    const { name, mobile, size, quantity } = req.body || {};

    // Validate required fields
    if (!name || !mobile || !size || !quantity) {
      return res.status(400).json({
        success: false,
        error: "सर्व माहिती भरा"
      });
    }

    const qty = Number(quantity);

    if (!Number.isInteger(qty) || qty < 1) {
      return res.status(400).json({
        success: false,
        error: "टी-शर्ट संख्या योग्य टाका"
      });
    }

    // T-shirt price
    const amount = qty * 300;

    // Save booking to Supabase
    const { data, error } = await supabase
      .from("bookings")
      .insert([
        {
          name: String(name).trim(),
          mobile: String(mobile).trim(),
          size: String(size).trim(),
          quantity: qty,
          amount: amount
        }
      ])
      .select()
      .single();

    if (error) {
      console.error("Supabase error:", error);

      return res.status(500).json({
        success: false,
        error: "Booking save failed",
        details: error.message
      });
    }

    return res.status(200).json({
      success: true,
      message: "Booking successfully submitted",
      booking: data
    });

  } catch (error) {
    console.error("Server error:", error);

    return res.status(500).json({
      success: false,
      error: "Server error",
      details: error.message
    });
  }
}
