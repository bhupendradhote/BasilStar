function getPivotCalculations(high, low, close, open) {
    const round = (val) => parseFloat(val.toFixed(2));
  
    const classicP = (high + low + close) / 3;
    const classic = {
      P: round(classicP),
      R1: round((2 * classicP) - low),
      R2: round(classicP + (high - low)),
      R3: round(high + 2 * (close - low)),
      S1: round((2 * classicP) - high),
      S2: round(classicP - (high - low)),
      S3: round(low - 2 * (high - close)),
    };
  
    const fibonacci = {
      P: round(classicP),
      R1: round(classicP + 0.382 * (high - low)),
      R2: round(classicP + 0.618 * (high - low)),
      R3: round(classicP + 1.000 * (high - low)),
      S1: round(classicP - 0.382 * (high - low)),
      S2: round(classicP - 0.618 * (high - low)),
      S3: round(classicP - 1.000 * (high - low)),
    };
  
    const camarilla = {
      P: round(classicP),
      R4: round(close + (high - low) * 1.5),
      R3: round(close + (high - low) * 1.25),
      R2: round(close + (high - low) * 1.1666),
      R1: round(close + (high - low) * 1.0833),
      S1: round(close - (high - low) * 1.0833),
      S2: round(close - (high - low) * 1.1666),
      S3: round(close - (high - low) * 1.25),
      S4: round(close - (high - low) * 1.5),
    };
  
    const woodieP = (high + low + 2 * open) / 4;
    const woodie = {
      P: round(woodieP),
      R1: round((2 * woodieP) - low),
      R2: round(woodieP + (high - low)),
      S1: round((2 * woodieP) - high),
      S2: round(woodieP - (high - low)),
    };
  
    let demarkP;
    if (close < open) {
      demarkP = (high + (2 * low) + close) / 4;
    } else if (close > open) {
      demarkP = ((2 * high) + low + close) / 4;
    } else {
      demarkP = (high + low + (2 * close)) / 4;
    }
  
    const demark = {
      P: round(demarkP),
      R1: round((2 * demarkP) - low),
      S1: round((2 * demarkP) - high),
    };
  
    return { classic, fibonacci, camarilla, woodie, demark };
  }
  