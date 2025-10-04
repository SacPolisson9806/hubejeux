const express = require("express");
const fetch = require("node-fetch");
const cors = require("cors");
const app = express();
app.use(cors());
app.use(express.json());

const NLP_API_KEY = "5417e82244f6ccf0453d983d067277c8efccc928";

app.post("/similarity", async (req, res) => {
  const { word1, word2 } = req.body;

  try {
    const response = await fetch("https://api.nlpcloud.io/v1/bert-base-french/semantic-similarity", {
      method: "POST",
      headers: {
        "Authorization": "Token " + NLP_API_KEY,
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        sentence1: word1,
        sentence2: word2
      })
    });

    const data = await response.json();
    res.json({ score: data.similarity_score });
  } catch (error) {
    console.error("Erreur NLP Cloud :", error);
    res.status(500).json({ score: 0 });
  }
});

app.listen(3000, () => console.log("✅ Backend lancé sur http://localhost:3000"));
