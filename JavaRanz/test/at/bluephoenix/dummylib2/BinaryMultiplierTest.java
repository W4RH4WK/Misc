package at.bluephoenix.dummylib2;

import org.junit.Test;

import static org.junit.Assert.assertEquals;

public class BinaryMultiplierTest {

    @Test
    public void MultiplicationTest() {
        assertEquals(15, BinaryMultiplier.multiply(3, 5));
    }

}
