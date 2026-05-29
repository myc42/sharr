#!/bin/bash

# ─────────────────────────────────────────────
# Test exhaustif : toutes les rooms 3 caractères (a-z)
# ─────────────────────────────────────────────

BASE_URL="http://localhost:8080"

PASS=0
FAIL=0
TOTAL=0

green() { echo -e "\033[32m✔ $1\033[0m"; }
red()   { echo -e "\033[31m✘ $1\033[0m"; }

echo "🚀 Test exhaustif de toutes les combinaisons 3 lettres (a-z)"
echo "Total attendu : 17576"
echo "─────────────────────────────────────────"

for a in {a..z}; do
  for b in {a..z}; do
    for c in {a..z}; do

      TOKEN="$a$b$c"
      TOTAL=$((TOTAL + 1))

      STATUS=$(curl -s -o /dev/null -w "%{http_code}" "$BASE_URL/$TOKEN")

      if [[ "$STATUS" == "200" || "$STATUS" == "302" ]]; then
          ((PASS++))
      else
          ((FAIL++))
          red "Échec pour $TOKEN (status: $STATUS)"
      fi

      # Progression
      if [ $((TOTAL % 500)) -eq 0 ]; then
          echo "  → $TOTAL / 17576 testés..."
      fi

    done
  done
done

echo "─────────────────────────────────────────"
echo "Total testé : $TOTAL (attendu: 17576)"
echo -e "  \033[32m$PASS succès\033[0m  |  \033[31m$FAIL erreurs\033[0m"
echo "─────────────────────────────────────────"

exit $(( FAIL == 0 ? 0 : 1 ))