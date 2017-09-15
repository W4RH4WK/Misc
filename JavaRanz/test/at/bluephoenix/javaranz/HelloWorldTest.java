package at.bluephoenix.javaranz;

import org.junit.Test;

import static org.junit.Assert.assertEquals;

public class HelloWorldTest {

    @Test
    public void helloOk() {
        assertEquals("Hello World", HelloWorld.hello());
    }

}
