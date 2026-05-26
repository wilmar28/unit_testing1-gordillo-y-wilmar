// Paso 4 — Mock de módulos externos con jest.mock()

jest.mock('axios');

const axios = require('axios');
const { getCurrentTemperature } = require('../weatherService');

describe('weatherService', () => {

  it('retorna la temperatura de la ciudad', async () => {
    axios.get.mockResolvedValue({ data: { temperature: 22 } });

    const temp = await getCurrentTemperature('Bogotá');

    expect(temp).toBe(22);
    expect(axios.get).toHaveBeenCalledWith(expect.stringContaining('Bogotá'));
  });

  it('propaga el error de red', async () => {
    axios.get.mockRejectedValue(new Error('Network Error'));

    await expect(getCurrentTemperature('Lima')).rejects.toThrow('Network Error');
  });

  it('llama a la URL correcta con la ciudad indicada', async () => {
    axios.get.mockResolvedValue({ data: { temperature: 18 } });

    await getCurrentTemperature('Medellín');

    expect(axios.get).toHaveBeenCalledWith(
      expect.stringContaining('Medellín')
    );
  });

});
