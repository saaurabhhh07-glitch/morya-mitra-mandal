const { createClient } = require('@supabase/supabase-js');

const supabase = createClient(
  process.env.SUPABASE_URL,
  process.env.SUPABASE_SERVICE_ROLE_KEY
);

module.exports = async (req, res) => {
  if (req.method !== 'POST') {
    return res.status(405).json({ error: 'Method not allowed' });
  }

  try {
    const { name, mobile, size, quantity } = req.body;

    if (!name || !mobile || !size || !quantity) {
      return res.status(400).json({
        error: 'सर्व माहिती भरा'
      });
    }

    const amount = Number(quantity) * 300;

    const { data, error } = await supabase
      .from('bookings')
      .insert([
        {
          name,
          mobile,
          size,
          quantity: Number(quantity),
          amount
        }
      ])
      .select();

    if (error) {
      return res.status(500).json({
        error: error.message
      });
    }

    return res.status(200).json({
      success: true,
      booking: data[0]
    });

  } catch (error) {
    return res.status(500).json({
      error: error.message
    });
  }
};
